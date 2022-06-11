<?php

namespace Tests\Feature;
use App\Models\Cajero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CajeroManagmentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function cajero_puede_ser_creado()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/administrar/cajero/crear',[
            'nombre' => 'Pizza'
        ]);

        //$response->assertOk();
        $this->assertCount(1,Cajero::all());

        $categoria = Cajero::first();

        $this->assertEquals($categoria->nombre,'Pizza');

        $response->assertRedirect('/administrar/cajero/'.$categoria->id);
    }

    
    /** @test */
    public function lista_de_cajero_puede_ser_recuperado()
    {
        $this->withoutExceptionHandling();

        //$categorias = factory(CategoriaFactory::class,3)->create(); // Datos de prueba
        //Categoria::factory()->create();
        Cajero::factory()->count(3)->create();

        $response = $this->get('/administrar/cajero'); // Llamo a la ruta

        $response->assertOk();

        $categorias = Cajero::all();

        $response->assertViewIs('administrar.index');

        $response->assertViewHas('categorias',$categorias);

    }
    
    /** @test */
    public function cajero_puede_ser_recuperado()
    {
        $this->withoutExceptionHandling();

        //$categorias = factory(CategoriaFactory::class,3)->create(); // Datos de prueba
        //Categoria::factory()->create();
        $categoria = Cajero::factory()->create();

        $response = $this->get('/administrar/cajero/'.$categoria->id); // Llamo a la ruta

        $response->assertOk();

        $categoria = Cajero::first();

        $response->assertViewIs('administrar.show');

        $response->assertViewHas('categoria',$categoria);
    }

    /** @test */
    public function cajero_puede_ser_actualizado()
    {
        $this->withoutExceptionHandling();

        $categoria = Cajero::factory()->create();

        $response = $this->put('/administrar/cajero/actualizar/'.$categoria->id,[
            'nombre' => 'Pizza'
        ]);

        //$response->assertOk();
        $this->assertCount(1,Cajero::all());

        $categoria = $categoria->fresh();

        $this->assertEquals($categoria->nombre,'Pizza');

        $response->assertRedirect('/administrar/cajero/'.$categoria->id);
    }

    /** @test */
    public function cajero_puede_ser_eliminado()
    {
        $this->withoutExceptionHandling();

        $categoria = Cajero::factory()->create();

        $response = $this->delete('/administrar/cajero/eliminar/'.$categoria->id);

        //$response->assertOk();
        $this->assertCount(0,Cajero::all());

        $response->assertRedirect('/administrar/cajero');
    }

    /** @test */
    public function nombre_cajero_requerido()
    {
        //$this->withoutExceptionHandling();
        
        $response = $this->post('/administrar/cajero/crear',[
            'nombre' => ''
        ]);

        $response->assertSessionHasErrors(['nombre']);

    }
}
