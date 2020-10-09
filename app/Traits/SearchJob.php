<?php

namespace App\Traits;

trait SearchJob
{
    protected function searchFullText($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '#', '!', '.', '*', '~'];
        $term = str_replace($reservedSymbols, '', $term);
        $words = explode(' ', $term);
        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 2) {
                $words[$key] = '+' . $word . '*';
            }
        }
        $searchTerm = implode(' ', $words);
        return $searchTerm;
    }
    /**
 * Scope a query that matches a full text search of term.
 * This version calculates and orders by relevance score.
 *
 * @param \Illuminate\Database\Eloquent\Builder $query
 * @param string $term
 * @return \Illuminate\Database\Eloquent\Builder
 */
public function scopeSearch($query, $term)
{
    $columns = implode(',',$this->searchable);
 
    $searchableTerm = $this->searchFullText($term);
 
    return $query->selectRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE) AS relevance_score", [$searchableTerm])
        ->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $searchableTerm)
        ->orderByDesc('relevance_score');
}
}