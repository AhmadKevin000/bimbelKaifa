<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Jenjang;
use App\Models\TarifSpp;

class FinanceService
{
    /**
     * Calculate SPP based on program, jenjang, and subject count by fetching from database.
     */
    public function calculateSpp(string $programName, string $jenjangName, int $subjectCount = 0): int
    {
        static $cachedPrograms = [];
        static $cachedJenjangs = [];

        if (!isset($cachedPrograms[$programName])) {
            $cachedPrograms[$programName] = Program::where('nama', $programName)->first();
        }
        $program = $cachedPrograms[$programName];

        if (!isset($cachedJenjangs[$jenjangName])) {
            $cachedJenjangs[$jenjangName] = Jenjang::where('nama', $jenjangName)->first();
        }
        $jenjang = $cachedJenjangs[$jenjangName];

        if (!$program) return 0;

        $tarifQuery = TarifSpp::where('program_id', $program->id);
        
        if ($jenjang) {
            $tarifQuery->where(function ($q) use ($jenjang) {
                $q->where('jenjang_id', $jenjang->id)->orWhereNull('jenjang_id');
            });
        } else {
            $tarifQuery->whereNull('jenjang_id');
        }

        // Specific jenjang takes priority over null jenjang
        $tarif = $tarifQuery->orderBy('jenjang_id', 'desc')->first();

        if (!$tarif) return 0;

        if ($tarif->type === 'per_mapel') {
            return (int) $tarif->nominal * max(1, $subjectCount);
        }

        return (int) $tarif->nominal;
    }

    /**
     * Registration fee is flat for all programs.
     */
    public function getRegistrationFee(): int
    {
        return 50000;
    }
}
