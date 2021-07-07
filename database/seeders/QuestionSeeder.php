<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = $this->data();
        foreach($questions as $question){
            Question::create([
                'company_id' => 1,
                'question' => $question['question'],
                'description' => $question['description']
            ]);
        }
    }

    public function data(){
        return [
            [
                'company_id' => 1,
                'question' => '¿El vehículo viene con su documentación?', 'description' => '¿El vehículo viene con su documentación?'
            ],
            [
                'company_id' => 1,
                'question' => '¿Según los estándares de ALD el vehículo necesita de reparación de carrocería?', 'description' => '¿Según los estándares de ALD el vehículo necesita de reparación de carrocería?'
            ],
            [
                'company_id' => 1,
                'question' => '¿Según los estándares de ALD el vehículo requiere de intervención mecánica o revisión?', 'description' => '¿Según los estándares de ALD el vehículo requiere de intervención mecánica o revisión?'
            ],
            [
                'company_id' => 1,
                'question' => '¿Según los estándares de ALD requiere pasar una ITV?','description' => '¿Según los estándares de ALD requiere pasar una ITV?'
            ],
            [
                'company_id' => 1,
                'question' => '¿Requiere el vehículo de alguna limpieza especial?','description' => '¿Requiere el vehículo de alguna limpieza especial?'
            ],
            [
                'company_id' => 1,
                'question' => '¿Presenta el vehículo algún tipo de rotulación que no sea de Carflex o Reflex?','description' => '¿Presenta el vehículo algún tipo de rotulación que no sea de Carflex o Reflex?'
            ],
            [
                'company_id' => 1,
                'question' => '¿El vehículo tiene instalado algún accesorio?', 'description' => '¿El vehículo tiene instalado algún accesorio?'
            ],
            [
                'company_id' => 2,
                'question' => 'Estado general de carrocería'
            ],
            [
                'company_id' => 2,
                'question' => 'Estado lunas y espejos'
            ],
            [
                'company_id' => 2,
                'question' => 'Sonido de motor y transmisiones'
            ],
            [
                'company_id' => 2,
                'question' => 'Estado faros e iluminación exterior intermitentes/luces de emergencia/luz de freno'
            ],
            [
                'company_id' => 2,
                'question' => 'Estado neumáticos, presiones, aspecto y desgaste y rueda de repuesto/kit antipinchazos'
            ],
            [
                'company_id' => 2,
                'question' => 'Niveles'
            ],
            [
                'company_id' => 2,
                'question' => 'Estado escobillas limpia-parabrisas, delanteras y traseras'
            ],
            [
                'company_id' => 2,
                'question' => 'Surtidores de agua limpia-parabrisas, delantero y trasero'
            ],
            [
                'company_id' => 2,
                'question' => 'Estado interior (Tapicería, salpicadero y paneles de puertas)'
            ],
            [
                'company_id' => 2,
                'question' => 'Iluminación de panel de instrumentos'
            ],
            [
                'company_id' => 2,
                'question' => 'Iluminación interior'
            ],
            [
                'company_id' => 2,
                'question' => 'Bocina, radio y GPS'
            ],
            [
                'company_id' => 2,
                'question' => 'Alfombrillas tiene todas (buen estado)'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de herramientas (Gato, manivelas, etc)'
            ],
            [
                'company_id' => 2,
                'question' => 'Distintivo medioambiental'
            ],
            [
                'company_id' => 2,
                'question' => 'Nivel de aceite (comporbar kms vs próximo cambio)'
            ],
            [
                'company_id' => 2,
                'question' => 'Nivel de líquido de frenos'
            ],
            [
                'company_id' => 2,
                'question' => 'Nivel líquido refrigerante'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación estado de pastillas de freno y estado de discos'
            ],
            [
                'company_id' => 2,
                'question' => 'Nivel de AdBLUE (Si lo llevase)'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación del kit antipinchazos (en vehículos sin rueda de repuesto)'
            ],
            [
                'company_id' => 2,
                'question' => 'Nivel líquido reductora y transmisiones'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión transmisiones y caja de transfer'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión correas de servicio (Tensión y estado)'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión cerraduras y cierre centralizado'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión tiradores de puertas'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión de espejos retrovisores exteriores'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión presión neumáticos incluido repuesto'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión de antena de radio'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión tapa de combustible'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión, lunas'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión del cuadro de instrumentos y mediciones / nivel de carburante'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de luces y mandos y llave de arranque (pila de mando)'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión de funcionamiento lunetas térmicas'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de freno de mano (eficiencia y altura de palanca)'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación calefacción, aire acondicionado y mandos'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación airbags'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación parasoles y espejos interiores'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación ajustes de retrovisores'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de tiradores de puertas y elevalunas'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación deñ bloqueo de las puertas'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de funcionamiento de radio, Bluetooth, GPS, tarjeta de datos'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación cinturones de seguridad (Limpieza y ajustes)'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación reglajes asientos y estado de tapiceria'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de luces interiores'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación bandeja trasera tapa objetos'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación tapas guantera y cerraduras'
            ],
            [
                'company_id' => 2,
                'question' => 'Revisión puertas traseras y laterales'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación estado de la caja de carga y protección de paneles de madera'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación estado del extintor, triángulos y chaleco reflectante'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de accesorios (Enganche, Cabrestante, Estanterías y rejilla separadora)'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de herramientas (Gato, manivelas, etc.)'
            ],
            [
                'company_id' => 2,
                'question' => 'Comprobación de documentación cotejada (Ficha técnica, Permiso de circulación y Póliza de seguro'
            ],
            [
                'company_id' => 2,
                'question' => 'Carpeta corporativa con manual de conductor y parte amistoso de accidente'
            ],
            [
                'company_id' => 2,
                'question' => 'Manual de instrucciones del fabricante y libro de garantía'
            ],
            [
                'company_id' => 2,
                'question' => 'Limpieza exterior'
            ],
            [
                'company_id' => 2,
                'question' => 'Aspirado interior'
            ],
            [
                'company_id' => 2,
                'question' => 'Limpieza de asientos'
            ],
            [
                'company_id' => 2,
                'question' => 'Limpieza tapicería'
            ],
        ];
    }
}
