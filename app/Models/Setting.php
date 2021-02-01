<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Setting
 * @package App\Models
 *
 * @property integer $id
 * @property string $group
 * @property string $name
 * @property string|null $value
 * @property string $type
 * @property string $array_sep
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Setting extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    #region Custom Functions

    public static function getAllGrouped() {
        try {
            /*$collection = Setting::all()->groupBy('group');
            foreach ($collection as $group => $coll) {
                foreach ($coll as $sett) {
                    $final_array[$group][$sett->name] = self::getParsedValue($sett);
                }
            }*/

            $all_settings = Setting::all()->toArray();
            $tree_settings = self::buildTree($all_settings);
            $final_array = self::cleanTree($tree_settings);

            return $final_array;
        } catch (\Exception $e) {
            return [];
        }
    }

    private static function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['group_id'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['name']] = $element;
            }
        }

        return $branch;
    }

    private static function cleanTree($tree) {
        $final_tree = [];
        foreach ($tree as $key => $item) {
            if (isset($item['children'])) {
                $final_tree[$key]['default'] = $item['value'];
                $final_tree[$item['name']] = self::cleanTree($item['children']);
            } else {
                $final_tree[$key] = isset($item['value']) ? self::getParsedValue($item) : $item;
            }
        }
        return $final_tree;
    }

    private static function getParsedValue($setting) {
        if ($setting['value'] === null) {
            return $setting['value'];
        } elseif ($setting['type'] === "string") {
            return $setting['value'];
        } elseif ($setting['type'] === "integer") {
            return (int)$setting['value'];
        } elseif ($setting['type'] === "bool") {
            return (bool)$setting['value'];
        } elseif ($setting['type'] === "float") {
            return (float)$setting['value'];
        } elseif ($setting['type'] === "array") {
            return explode($setting['array_sep'], $setting['value']);
        }
        return $setting['value'];
    }

    #endregion
}
