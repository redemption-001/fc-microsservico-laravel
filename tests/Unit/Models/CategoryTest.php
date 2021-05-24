<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;
    private $category;

    //é executado somente uma vez
    //para configurações globais de teste
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    //executado antes de cada teste
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    //executado depois de cada teste
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    //é executado somente uma vez no final de tudo
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];
        $categoryTraits = \array_keys(\class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
        //\print_r(\class_uses(Category::class));
    }

    public function testFillableAttribute()
    {
        $fillable = ['name', 'description', 'is_active'];
        $this->assertEquals($fillable, $this->category->getFillable());
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        //dd($dates, $this->category->getDates());
        //retorna false porque o array tem indice diferente
        //$this->assertEquals($dates, $this->category->getDates());

        //validar somente se existe o valor
        foreach ($dates as $date) {
            $this->assertContains($date, $this->category->getDates());
        }

        //forcar a alteracao do teste em caso de mudanca, comparando o tamanho do array
        $this->assertCount(count($dates), $this->category->getDates());
    }

    public function testCastsAttribute()
    {
        $casts = [
            'id' => 'string',
            'is_active' => 'boolean'
        ];
        $this->assertEquals($casts, $this->category->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->category->getIncrementing());
    }
}
