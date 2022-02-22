<?php

namespace Tests\Feature;

use App\Authenticatable\Admin;
use App\Authenticatable\Assistant;
use App\Lead;
use App\Notifications\NewComment;
use App\Notifications\TicketEscalated;
use App\Services\Bitbucket\Bitbucket;
use App\Services\IssueCreator;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Mockery\Mock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentsTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function admin_can_see_agents()
    {
        $admin = Admin::factory()->create();
        $agents = User::factory()->count(3)->create();
        $response = $this->actingAs($admin)->get('users');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee($agents->first()->name);
    }

    /** @test */
    public function non_admin_can_not_see_agents()
    {
        $nonAdmin= User::factory()->create();
        $response = $this->actingAs($nonAdmin)->get('users');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function can_delete_agent()
    {
        $admin = Admin::factory()->create();
        $agent = User::factory()->create();
        $agent->tickets()->create(
          Ticket::factory()->make()->toArray()
        );
        $agent->leads()->create(
            Lead::factory()->make()->toArray()
        );
        $this->assertNotNull(Ticket::first()->user_id);
        $this->assertNotNull(Lead::first()->user_id);

        $response = $this->actingAs($admin)->delete("users/{$agent->id}");

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals(1, User::count());
        $this->assertNull(Ticket::first()->user_id);
        $this->assertNull(Lead::first()->user_id);
    }

    /** @test */
    public function non_admin_cannot_delete_agents()
    {
        $nonAdmin = User::factory()->create();
        $agent = User::factory()->create();

        $response = $this->actingAs($nonAdmin)->delete("users/{$agent->id}");

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertEquals(2, User::count());
    }
}
