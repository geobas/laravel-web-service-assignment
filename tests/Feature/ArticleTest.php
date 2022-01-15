<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Helpers\HttpStatus as Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->initDatabase();
    }

    public function tearDown(): void
    {
        $this->resetDatabase();

        parent::tearDown();
    }

    /**
     * @test
     */
    public function get_all_articles()
    {
        $this->getJson('api/v1/articles')
             ->assertStatus(Status::OK)
             ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'title',
                        'content',
                        'category',
                        'uuid',
                        'creation_date',
                        'comments',
                    ],
                ],
             ]);
    }

    /**
     * @test
     */
    public function get_one_article()
    {
        $this->getJson('api/v1/articles/1')
             ->assertStatus(Status::OK)
             ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'category',
                    'uuid',
                    'creation_date',
                    'comments',
                ],
             ]);
    }

    /**
     * @test
     */
    public function create_one_article()
    {
        $this->postJson('api/v1/articles', [
                'title' => 'Nulla voluptatibus esse quibusdam id omnis.',
                'content' => 'Fusce euismod ullamcorper mi, vel volutpat felis maximus in. Proin ornare pharetra convallis. Quisque ultricies libero eu eros tempus ornare quis quis nisi. Phasellus id ante a lorem pharetra egestas ullamcorper vitae tellus.',
                'category' => 'General',
             ])
             ->assertStatus(Status::CREATED)
             ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'category',
                    'uuid',
                    'creation_date',
                ],
             ])
             ->assertJson([
                'data' => [
                    'title' => 'Nulla voluptatibus esse quibusdam id omnis.',
                    'content' => 'Fusce euismod ullamcorper mi, vel volutpat felis maximus in. Proin ornare pharetra convallis. Quisque ultricies libero eu eros tempus ornare quis quis nisi. Phasellus id ante a lorem pharetra egestas ullamcorper vitae tellus.',
                    'category' => 'General',
                ],
             ]);

        $this->postJson('api/v1/articles')
             ->assertStatus(Status::BAD_REQUEST)
             ->assertJson([
                'errors' => [
                    'title' => [
                        'title is required',
                    ],
                    'content' => [
                        'content is required',
                    ],
                ],
             ]);
    }

    /**
     * @test
     */
    public function update_one_article()
    {
        $this->putJson('api/v1/articles/1', [
                'title' => 'Lorem ipsum',
                'content' => 'Occaecati voluptas ipsum nesciunt. Provident quo magnam similique fuga quibusdam. Consectetur aperiam ea quas ad est.',
                'category' => 'Nature',
             ])
             ->assertStatus(Status::OK)
             ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'category',
                    'uuid',
                    'creation_date',
                ],
             ])
             ->assertJson([
                'data' => [
                    'title' => 'Lorem ipsum',
                    'content' => 'Occaecati voluptas ipsum nesciunt. Provident quo magnam similique fuga quibusdam. Consectetur aperiam ea quas ad est.',
                    'category' => 'Nature',
                ],
             ]);
    }

    /**
     * @test
     */
    public function delete_one_article()
    {
        $this->deleteJson('api/v1/articles/1')
             ->assertStatus(Status::OK)
             ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'category',
                    'uuid',
                    'creation_date',
                ],
             ]);
    }
}
