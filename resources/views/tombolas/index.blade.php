@extends('app')

@section('app_content')

    <section class="section">

        <div class="container">

            <div class="tw-bg-white tw-shadow-md tw-rounded tw-px-3 md:tw-px-8 tw-pt-3 md:tw-pt-6 tw-pb-3 md:tw-pb-8 tw-mb-4">

                <div class="tw-mb-4">

                    <h2 class="tw-text-blue-600 tw-text-lg tw-font-bold tw-mb-3 tw-border-b tw-border-gray-400 tw-pb-2">Tombolas</h2>

                    <!-- SEARCH FORM -->

                    <search-form
                        group="tombola-search"
                        url="{{ route('tombola.fetch') }}"
                        :params="{
                            search: '',
                            per_page: {{ $defaultPerPage }},
                            page: 1,
                            order_by: 'id:desc',
                            datecreate_du: '',
                            datecreate_au: '',
                            statuts: '',
                            }"
                        v-slot="{ params, update, change, clear, processing }"
                    >

                        <form class="tw-grid tw-grid-cols-8 tw-col-gap-4 tw-pb-3 tw-border-b tw-border-gray-400">
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="datecreate_du"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Du
                                </label>
                                <div class="relative">
                                    <vue2-datepicker id="datecreate_du" lang="fr" style="width: 90%; height: 90%;" v-model="params.datecreate_du" format="YYYY-MM-DD" @change="change"></vue2-datepicker>
                                </div>
                            </div>

                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="datecreate_au"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Au
                                </label>
                                <div class="relative">
                                    <vue2-datepicker id="datecreate_au" lang="fr" style="width: 90%; height: 90%;" v-model="params.datecreate_au" format="YYYY-MM-DD" @change="change"></vue2-datepicker>
                                </div>
                            </div>
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2" for="search">
                                    Recherche
                                </label>
                                <div class="tw-relative">
                                    <span
                                        v-if="params.search"
                                        @click="clear({ search: '' })"
                                        class="tw-absolute tw-top-0 tw-right-0 tw-mt-4 mr-4 tw-text-gray-500 tw-cursor-pointer"
                                    >
                                        <times-circle
                                            class="tw-fill-current tw-h-4 tw-pointer-events-none"
                                        ></times-circle>
                                    </span>
                                    <input
                                        v-model="params.search"
                                        @input="update"
                                        @keydown.enter.prevent
                                        type="text"
                                        id="search"
                                        name="search"
                                        class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-10 tw-mb-3 md:tw-mb-0 tw-leading-tight focus:tw-outline-none"
                                        placeholder="Rechercher..."
                                    >
                                </div>
                            </div>

                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="statuts"
                                    class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Statut
                                </label>
                                <div class="tw-inline-flex">
                                    <div class="tw-relative">
                                        <select
                                            v-model="params.statuts"
                                            @change="change"
                                            id="statuts"
                                            class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"

                                        >
                                            <option
                                                v-for="statut in {{ $statuts }}"
                                                :value="statut.id"
                                            >@{{ statut.name }}</option>
                                        </select>
                                        <select-angle></select-angle>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" id="statuts_clear" name="statuts_clear" class="btn btn-default" @click="[params.statuts= '', change()]"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </search-form>

                    <!--/ SEARCH FORM -->


                    <!-- RESULTS -->

                    <search-results group="tombola-search" v-slot="{ total, records }">

                        <div class="tw-text-sm">

                            <div class="tw-flex tw-flex-wrap tw-p-4 tw-bg-gray-700 tw-text-white tw-rounded-sm">
                                <div class="tw-flex-auto tw-pr-3">Total : @{{ total }}</div>
                            </div>


                            <template v-if="records.length">



                                <div class="tw-p-10 tw-grid tw-grid-cols-1 sm:tw-grid-cols-1 md:tw-grid-cols-3 lg:tw-grid-cols-3 xl:tw-grid-cols-3 tw-gap-5">


                                    <div v-for="record in records"
                                         :key="record.id" class="tw-rounded tw-overflow-hidden tw-shadow-lg">
                                        <img class="tw-w-full" src="assets/images/tombola-default.jpg" alt="Mountain">
                                        <div class="tw-px-6 tw-py-4">
                                            <div class="tw-font-bold tw-text-xl tw-mb-2">
                                                <small>
                                                    <span v-if="record.statutcode == 'inactive'" class="badge badge-danger">@{{ record.id }}</span>
                                                    <span v-else class="badge badge-success">@{{ record.id }}</span>
                                                </small>
                                                .
                                                <a
                                                    :href="record.edit_url"
                                                    class="tw-inline-block tw-text-blue-500">
                                                    @{{ record.titre }}
                                                </a>
                                            </div>
                                            <div class="tw-font-bold tw-text-xs tw-mb-2">
                                                Règlement
                                                <a
                                                    :href="record.fichierreglement_url"
                                                    class="tw-inline-block tw-text-red-500">
                                                    <i class="fa fa-paperclip"></i>
                                                </a>
                                            </div>
                                            <div class="tw-font-thin tw-text-xs tw-mb-2" v-if="record.participation_unique"><i class="fa fa-comment-o"></i> Participation Unique</div>
                                            <div class="tw-font-thin tw-text-xs tw-mb-2" v-else><i class="fa fa-comments-o"></i>
                                                <span>Unité Participation: @{{ record.participation_unite }}</span>
                                                <span>Valeur unitaire: @{{ record.participation_valeurunitaire }}</span>
                                            </div>

                                            <p class="tw-text-gray-700 tw-text-base">@{{ record.description }}</p>
                                        </div>

                                    </div>



                                </div>

                            </template>

                            <div
                                v-else
                                class="tw-flex tw-flex-wrap tw-p-4 border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700"
                            >
                                There are no records available
                            </div>

                        </div>

                    </search-results>

                    <!--/ RESULTS -->


                    <!-- PAGINATION -->

                    <search-pagination group="tombola-search" :always-show="true"></search-pagination>

                    <!--/ PAGINATION -->

                </div>

            </div>
        </div>

    </section>

@endsection
