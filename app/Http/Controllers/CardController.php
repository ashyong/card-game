<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CardController extends Controller
{
    private array $suits = ['S', 'H', 'D', 'C'];
    private array $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K'];

    public function index(): View
    {
        return view('cards.index');
    }

    public function distribute(Request $request): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            'num_people' => 'required|integer|min:1'
        ]);

        try {
            $numPeople = $validated['num_people'];
            $deck = $this->generateDeck();
            $shuffledDeck = $this->shuffleDeck($deck);
            $distribution = $this->distributeCards($shuffledDeck, $numPeople);

            return response()->json([
                'status' => 'success',
                'distribution' => $distribution
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Irregularity occurred'
            ], 500);
        }
    }

    private function generateDeck(): array
    {
        $deck = [];
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $deck[] = "$suit-$value";
            }
        }
        return $deck;
    }

    private function shuffleDeck(array $deck): array
    {
        for ($i = count($deck) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$deck[$i], $deck[$j]] = [$deck[$j], $deck[$i]];
        }
        return $deck;
    }

    private function distributeCards(array $deck, int $numPeople): array
    {
        $distribution = array_fill(0, $numPeople, []);
        foreach ($deck as $index => $card) {
            $personIndex = $index % $numPeople;
            $distribution[$personIndex][] = $card;
        }
        return $distribution;
    }
}
