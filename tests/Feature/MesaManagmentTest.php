<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Mesa;

class MesaManagmentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function mesa_puede_ser_creado()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/administrar/mesa/crear',[
            'nombre' => 'Pizza'
        ]);

        //$response->assertOk();
        $this->assertCount(1,Mesa::all());

        $categoria = Mesa::first();

        $this->assertEquals($categoria->nombre,'Pizza');

        $response->assertRedirect('/administrar/mesa/'.$categoria->id);
    }

    
    /** @test */
    public function lista_de_mesa_puede_ser_recuperado()
    {
        $this->withoutExceptionHandling();

        //$categorias = factory(CategoriaFactory::class,3)->create(); // Datos de prueba
        //Categoria::factory()->create();
        Mesa::factory()->count(3)->create();

        $response = $this->get('/administrar/mesa'); // Llamo a la ruta

        $response->assertOk();

        $categorias = Mesa::all();

        $response->assertViewIs('administrar.index');

        $response->assertViewHas('categorias',$categorias);

    }
    
    /** @test */
    public function mesa_puede_ser_recuperado()
    {
        $this->withoutExceptionHandling();

        //$categorias = factory(CategoriaFactory::class,3)->create(); // Datos de prueba
        //Categoria::factory()->create();
        $categoria = Mesa::factory()->create();

        $response = $this->get('/administrar/mesa/'.$categoria->id); // Llamo a la ruta

        $response->assertOk();

        $categoria = Mesa::first();

        $response->assertViewIs('administrar.show');

        $response->assertViewHas('categoria',$categoria);
    }

    /** @test */
    public function mesa_puede_ser_actualizado()
    {
        $this->withoutExceptionHandling();

        $categoria = Mesa::factory()->create();

        $response = $this->put('/administrar/mesa/actualizar/'.$categoria->id,[
            'nombre' => 'Pizza'
        ]);

        //$response->assertOk();
        $this->assertCount(1,Mesa::all());

        $categoria = $categoria->fresh();

        $this->assertEquals($categoria->nombre,'Pizza');

        $response->assertRedirect('/administrar/mesa/'.$categoria->id);
    }

    /** @test */
    public function mesa_puede_ser_eliminado()
    {
        $this->withoutExceptionHandling();

        $categoria = Mesa::factory()->create();

        $response = $this->delete('/administrar/mesa/eliminar/'.$categoria->id);

        //$response->assertOk();
        $this->assertCount(0,Mesa::all());

        $response->assertRedirect('/administrar/mesa');
    }

    /** @test */
    public function nombre_mesa_requerido()
    {
        //$this->withoutExceptionHandling();
        
        $response = $this->post('/administrar/mesa/crear',[
            'nombre' => ''
        ]);

        $response->assertSessionHasErrors(['nombre']);

    }    
}
