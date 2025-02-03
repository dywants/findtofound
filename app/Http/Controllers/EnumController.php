<?php

namespace App\Http\Controllers;

use App\Enum\PieceCondition;

class EnumController extends Controller
{
    public function pieceConditions()
    {
        return response()->json(
            collect(PieceCondition::cases())->map(function ($case) {
                return [
                    'value' => $case->value,
                    'name' => $case->name,
                ];
            })
        );
    }
}
