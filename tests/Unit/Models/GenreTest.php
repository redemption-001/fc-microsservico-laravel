<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class GenreTest extends TestCase
{
    use DatabaseMigrations;
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];
        $genreTraits = \array_keys(\class_uses(Genre::class));
        $this->assertEquals($traits, $genreTraits);
    }

    public function testFillableAttribute()
    {
        $fillable = ['name', 'is_active'];
        $this->assertEquals($fillable, $this->genre->getFillable());
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $genresKeys = \array_values($this->genre->getDates());
        $this->assertEqualsCanonicalizing($dates, $genresKeys);
    }

    public function testCastsAttribute()
    {
        $casts = [
            'id' => 'string',
            'is_active' => 'boolean'
        ];
        $this->assertEquals($casts, $this->genre->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->genre->getIncrementing());
    }
}
