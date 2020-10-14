<?php

namespace App\Traits;

/**
 * Trait Search Full Text
 * 
 */
trait FullTextSearch
{
    /**
     * Replace whitespace with full text search wildcards
     * 
     * @param string term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        //remove symbol used by MySQL
        $reverseSymbol = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reverseSymbol, '', $term);

        $word = explode(' ', $term);

        foreach ($word as $key => $value) {
            /**
             * applying "+" operator only big word
             * Cause smaller one are not indexes by MySQL (indexes >= 4)
             */
            if (strlen($value) >= 2) {
                $word[$key] = '+' . $value . '*';
            }
        }

        $searchTerm = implode(' ', $word);
        return $searchTerm;
    }

    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term)
    {
        $columns = implode(',', $this->searchable);

        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($term));

        return $query;
    }
}
