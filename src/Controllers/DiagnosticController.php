<?php

namespace App\Controllers;

use App\Models\Diagnostic;

class DiagnosticController extends BaseController
{
    /**
     * Show diagnostic page
     */
    public function index(): void
    {
        $this->render('diagnostic', [
            'title' => 'Diagnostic - Athletic Trainer'
        ]);
    }

    /**
     * Get diagnostic by body part
     */
    public function getByBodyPart(): void
    {
        $bodyPart = $this->input('action', '', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (empty($bodyPart)) {
            $this->redirect('../view/diagnostic.php');
            return;
        }

        // Map body parts to search terms
        $searchMap = [
            'Ankle sprain' => 'ankle',
            'Ankle' => 'ankle',
            'Elbow' => 'elbow',
            'Groin' => 'groin',
            'Neck' => 'neck',
            'Thighs' => 'thighs',
            'Knee' => 'knee'
        ];

        $searchTerm = $searchMap[$bodyPart] ?? $bodyPart;
        $diagnostic = Diagnostic::getByName($searchTerm);
        
        if ($diagnostic) {
            $this->render('diagnostic_result', [
                'title' => 'Diagnostic Result - Athletic Trainer',
                'diagnostic' => $diagnostic,
                'bodyPart' => htmlspecialchars($bodyPart)
            ]);
        } else {
            $this->redirect('../view/diagnostic.php');
        }
    }
}
