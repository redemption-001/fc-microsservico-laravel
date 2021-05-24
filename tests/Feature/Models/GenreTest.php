<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use \Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testList()
    {
        \factory(Genre::class, 1)->create();


        $genres = Genre::all();
        $this->assertCount(1, $genres);


        $genresKeys = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genresKeys
        );
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);
        $genre->refresh();
        $this->assertTrue(RamseyUuid::isValid($genre->id));
        $this->assertEquals('test1', $genre->name);
        $this->assertTrue($genre->is_active);


        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($genre->is_active);


        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'test_name',
            'is_active' => false
        ]);
        $data = [
            'name' => 'test_name_updated',
            'is_active' => true
        ];
        $genre->update($data);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'test1',
            'is_active' => true
        ])->first();

        $genre->delete();
        $this->assertSoftDeleted('genres', [
            'id' => $genre->id
        ]);

        //dump(Genre::withTrashed()->get());        
    }

    public function testUuid()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'test1',
            'is_active' => true
        ])->first();
        $this->assertTrue(RamseyUuid::isValid($genre->id));
    }
}
