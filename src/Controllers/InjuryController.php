<?php

namespace App\Controllers;

use App\Models\Injury;

class InjuryController extends BaseController
{
    /**
     * Search for injuries
     */
    public function search(): void
    {
        $keyword = $this->input('action', '', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (empty($keyword)) {
            $this->render('injuries', [
                'title' => 'Injuries - Athletic Trainer',
                'name' => null,
                'result' => []
            ]);
            return;
        }

        $results = Injury::getByName($keyword);
        
        $this->render('injuries', [
            'title' => 'Search Results - Athletic Trainer',
            'name' => htmlspecialchars($keyword),
            'result' => $results
        ]);
    }

    /**
     * Show all injuries
     */
    public function index(): void
    {
        $injuries = Injury::getAll();
        
        $this->render('injuries', [
            'title' => 'All Injuries - Athletic Trainer',
            'name' => null,
            'result' => $injuries
        ]);
    }
}
