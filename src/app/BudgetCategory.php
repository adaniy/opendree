<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    protected $table = "budget_category";
    protected $fillable = [];

    /**
     * Model relationships
     *
     * Categories belongs to a budget
     * And categories has many depenses
     */

    public function budget()
    {
        return $this->belongsTo("App\Budget");
    }

    public function depenses()
    {
        return $this->hasMany("App\BudgetDepense");
    }

    /**
     * Local scopes
     *
     * Data query list conditions
     */

    public function scopeList()
    {
        /** Does something ... */
    }

    /**
     * Local scopes
     *
     * Insertions queries
     */

    /** ... */

    /**
     * Local scopes
     *
     * Updates queries
     */

    /** ... */

    /**
     * Local scopes
     *
     * Deletions queries
     */

    /** ... */
}
