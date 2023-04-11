<?php

namespace Tests\Http\Controllers\Api;

use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    public function createApplication(): Application
    {
        $app = parent::createApplication();

        // create multiple random users with cards
        $users = User::factory()
            ->count(10)
            ->create();

        foreach ($users as $user) {
            Card::factory()
                ->count(2)
                ->create([
                    'user_id' => $user->id
                ]);
        }

        return $app;
    }

    public function testIndex()
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        Card::factory()
            ->count(3)
            ->create(['user_id' => $user->id]);

        $token = $user->createToken('auth-token')->plainTextToken;

        $this->json('get', '/api/cards', [], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'number',
                    'user_id',
                    'card_type_id'
                ]
            ])
            ->assertJsonCount(3);

        // check if the another cards that our user has no access to are available
        $this->assertDatabaseCount('cards', 23);
    }

    public function testCreateCardSuccess()
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        $card = Card::factory()
            ->make(['user_id' => $user->id]);

        $token = $user->createToken('auth-token')->plainTextToken;

        $this->json('POST', '/api/cards', $card->toArray(), [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertOk();

        // check if the card is saved to the database
        $this->assertDatabaseCount('cards', 21);
    }

    public function testCreateCardMissingParams()
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        Card::factory()
            ->make(['user_id' => $user->id]);

        $token = $user->createToken('auth-token')->plainTextToken;

        $this->json('POST', '/api/cards', [], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertStatus(422)
            ->assertInvalid([
                'number' => __('validation.required', ['attribute' => __('validation.attributes.number')]),
                'user_id' => __('validation.required', ['attribute' => __('validation.attributes.user_id')]),
                'card_type_id' => __('validation.required', ['attribute' => __('validation.attributes.card_type_id')])
            ]);

        // check if the card is saved to the database
        $this->assertDatabaseCount('cards', 20);
    }

    public function testDeleteCardSuccess()
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Card $card */
        $card = Card::factory()
            ->create(['user_id' => $user->id]);

        $token = $user->createToken('auth-token')->plainTextToken;

        $this->json('DELETE', '/api/cards/' . $card->id, [], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertOk();

        // check if the card number has been anonymized
        $this->assertDatabaseHas('cards', [
            'id' => $card->id,
            'number' => preg_replace("/\w(?=\w{4})/", '9', $card->number)
        ]);

        $this->assertSoftDeleted('cards', ['id' => $card->id]);

        // check if the card is not hard deleted
        $this->assertDatabaseCount('cards', 21);
    }

    public function testDeleteCardPermissionFailure()
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Card $card */
        $card = Card::first();

        $token = $user->createToken('auth-token')->plainTextToken;

        $this->json('DELETE', '/api/cards/' . $card->id, [], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertUnauthorized();

        $this->assertNotSoftDeleted('cards', $card->toArray());

        // check if the card is not hard deleted
        $this->assertDatabaseCount('cards', 20);
    }
}
