<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Eloquent\TombolaRepository;
use App\Repositories\Contracts\IUserRepositoryContract;
use App\Repositories\Contracts\IProductRepositoryContract;
use App\Repositories\Contracts\ITombolaRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(IUserRepositoryContract::class, UserRepository::class);
        $this->app->bind(ITombolaRepositoryContract::class, TombolaRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Laravel Macros are great way of extending Laravel's core classes and add extra functionality
         * required for our application.
         * It is a way to add somme missing functionality to Laravel's internal component with a piece of code
         * that doesn't exist in the Laravel class.
         *
         * Blueprint is macroable, so we can just define a macro on it in this service provider to get base fields
         */
        Blueprint::macro('baseFields', function () {
            $this->uuid('uuid');
            $this->string('tags')->nullable()->comment('Tags, if any');
            $this->foreignId('status_id')->nullable()
                ->comment('status reference')
                ->constrained('statuses')->onDelete('set null');
            $this->boolean('is_default')->default(false)->comment('determine whether is the default one.');
            $this->timestamps();
        });
        Blueprint::macro('dropBaseForeigns', function () {
            $this->dropForeign(['status_id']);
        });

        Blueprint::macro('participantUrneFields', function () {
            $this->id();

            $this->foreignId('urne_id')->nullable()
                ->comment('reference de l urne')
                ->constrained('urnes')->onDelete('set null');

            $this->foreignId('participant_id')->nullable()
                ->comment('reference du participant')
                ->constrained('participants')->onDelete('set null');

            $this->integer('posi')->default(0)->comment('position de l occurence (base 0)');

            $this->timestamps();
        });

        Blueprint::macro('dropParticipantUrneForeigns', function () {
            $this->dropForeign(['urne_id']);
            $this->dropForeign(['participant_id']);
        });

        JsonResource::withoutWrapping();

        /**
         * tell Laravel that, when the App boots,
         * which is after all other Services are already registered,
         * we are gonna add to the config array our own settings
         */
        config([
            'Settings' => Setting::getAllGrouped()
        ]);
    }
}
