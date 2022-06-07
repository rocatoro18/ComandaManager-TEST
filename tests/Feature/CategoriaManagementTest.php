<?php

namespace Tests\Feature;

use App\Models\Categoria;
//use database\factories\CategoriaFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriaManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function categoria_puede_ser_creada()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/administrar/categoria/crear',[
            'nombre' => 'Pizza'
        ]);

        //$response->assertOk();
        $this->assertCount(1,Categoria::all());

        $categoria = Categoria::first();

        $this->assertEquals($categoria->nombre,'Pizza');

        $response->assertRedirect('/administrar/categoria/'.$categoria->id);
    }

    
    /** @test */
    public function lista_de_categoria_puede_ser_recuperada()
    {
        $this->withoutExceptionHandling();

        //$categorias = factory(CategoriaFactory::class,3)->create(); // Datos de prueba
        //Categoria::factory()->create();
        Categoria::factory()->count(3)->create();

        $response = $this->get('/administrar/categoria'); // Llamo a la ruta

        $response->assertOk();

        $categorias = Categoria::all();

        $response->assertViewIs('administrar.index');

        $response->assertViewHas('categorias',$categorias);

    }
    
    /** @test */
    public function categoria_puede_ser_recuperada()
    {
        $this->withoutExceptionHandling();

        //$categorias = factory(CategoriaFactory::class,3)->create(); // Datos de prueba
        //Categoria::factory()->create();
        $categoria = Categoria::factory()->create();

        $response = $this->get('/administrar/categoria/'.$categoria->id); // Llamo a la ruta

        $response->assertOk();

        $categoria = Categoria::first();

        $response->assertViewIs('administrar.show');

        $response->assertViewHas('categoria',$categoria);
    }

    /** @test */
    public function categoria_puede_ser_actualizada()
    {
        $this->withoutExceptionHandling();

        $categoria = Categoria::factory()->create();

        $response = $this->put('/administrar/categoria/actualizar/'.$categoria->id,[
            'nombre' => 'Pizza'
        ]);

        //$response->assertOk();
        $this->assertCount(1,Categoria::all());

        $categoria = $categoria->fresh();

        $this->assertEquals($categoria->nombre,'Pizza');

        $response->assertRedirect('/administrar/categoria/'.$categoria->id);
    }

    /** @test */
    public function categoria_puede_ser_eliminada()
    {
        $this->withoutExceptionHandling();

        $categoria = Categoria::factory()->create();

        $response = $this->delete('/administrar/categoria/eliminar/'.$categoria->id);

        //$response->assertOk();
        $this->assertCount(0,Categoria::all());

        $response->assertRedirect('/administrar/categoria');
    }

    /** @test */
    public function nombre_categoria_requerido()
    {
        //$this->withoutExceptionHandling();
        
        $response = $this->post('/administrar/categoria/crear',[
            'nombre' => ''
        ]);

        $response->assertSessionHasErrors(['nombre']);

    }

}
