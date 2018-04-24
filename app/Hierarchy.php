<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Important note: using the adjacency list model in this project for UI handling simplicity
 * Class Hierarchy
 * @package App
 */
class Hierarchy extends Model
{
    protected $with = [];

    protected $fillable = ['parent_id', 'user_id'];

    protected $visible = ['user_id', 'parent_id', 'user'];

    /**
     * Hierarchy tree from current unit to all descendants
     * note - currently supports up to 6 levels of depth
     * @return Collection|array
     */
    public function tree() {
        return $this->children()->with(['user', 'children.user', 'children.children.user', 'children.children.children.user', 'children.children.children.children.user'])->get();
    }

    // ----- [static] ----- //

    /**
     * Creates or updates a child hierarchy row
     * @param $hierarchyId
     * @param $userId
     */
    static public function setChild($hierarchyId, $userId) {
        self::updateOrCreate(['user_id' => $userId], ['parent_id' => $hierarchyId]);
    }

    // ----- [relationships] ----- //

    /**
     * Returns user associated with hierarchy instance
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Children of hierarchy
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Returns parent hierarchy model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
