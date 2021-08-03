<?php

namespace Database\Seeders;

use App\Models\Company;
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
                'company_id' => $question['company_id'],
                'question' => $question['question'],
                'description' => $question['description']
            ]);
        }
    }

    public function data(){
        return [
            [
                'company_id' => Company::ALD,
                'question' => '¿El vehículo viene con su documentación?', 'description' => '¿El vehículo viene con su documentación?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿Según los estándares de ALD el vehículo necesita de reparación de carrocería?', 'description' => '¿Según los estándares de ALD el vehículo necesita de reparación de carrocería?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿Según los estándares de ALD el vehículo requiere de intervención mecánica o revisión?', 'description' => '¿Según los estándares de ALD el vehículo requiere de intervención mecánica o revisión?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿Según los estándares de ALD requiere pasar una ITV?','description' => '¿Según los estándares de ALD requiere pasar una ITV?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿Requiere el vehículo de alguna limpieza especial?','description' => '¿Requiere el vehículo de alguna limpieza especial?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿Presenta el vehículo algún tipo de rotulación que no sea de Carflex o Reflex?','description' => '¿Presenta el vehículo algún tipo de rotulación que no sea de Carflex o Reflex?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿El vehículo tiene instalado algún accesorio?', 'description' => '¿El vehículo tiene instalado algún accesorio?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿El vehículo presenta daños interiores?', 'description' => '¿El vehículo presenta daños interiores?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿El vehículo tiene el distintivo ambiental?', 'description' => '¿El vehículo tiene el distintivo ambiental?'
            ],
            [
                'company_id' => Company::ALD,
                'question' => '¿Las placas de matrículas están dañadas?', 'description' => '¿Las placas de matrículas están dañadas?'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Estado general de carrocería', 'description' => 'Estado general de carrocería'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Estado lunas y espejos', 'description' => 'Estado lunas y espejos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Sonido de motor y transmisiones', 'description' => 'Sonido de motor y transmisiones'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Estado faros e iluminación exterior intermitentes/luces de emergencia/luz de freno', 'description' => 'Estado faros e iluminación exterior intermitentes/luces de emergencia/luz de freno'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Estado neumáticos, presiones, aspecto y desgaste y rueda de repuesto/kit antipinchazos', 'description' => 'Estado neumáticos, presiones, aspecto y desgaste y rueda de repuesto/kit antipinchazos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Niveles', 'description' => 'Niveles'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Estado escobillas limpia-parabrisas, delanteras y traseras', 'description' => 'Estado escobillas limpia-parabrisas, delanteras y traseras'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Surtidores de agua limpia-parabrisas, delantero y trasero', 'description' => 'Surtidores de agua limpia-parabrisas, delantero y trasero'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Estado interior (Tapicería, salpicadero y paneles de puertas)', 'description' => 'Estado interior (Tapicería, salpicadero y paneles de puertas)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Iluminación de panel de instrumentos', 'description' => 'Iluminación de panel de instrumentos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Iluminación interior', 'description' => 'Iluminación interior'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Bocina, radio y GPS', 'description' => 'Bocina, radio y GPS'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Alfombrillas tiene todas (buen estado)', 'description' => 'Alfombrillas tiene todas (buen estado)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de herramientas (Gato, manivelas, etc)', 'description' => 'Comprobación de herramientas (Gato, manivelas, etc)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Distintivo medioambiental', 'description' => 'Distintivo medioambiental'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Nivel de aceite (comporbar kms vs próximo cambio)', 'description' => 'Nivel de aceite (comporbar kms vs próximo cambio)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Nivel de líquido de frenos', 'description' => 'Nivel de líquido de frenos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Nivel líquido refrigerante', 'description' => 'Nivel líquido refrigerante'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación estado de pastillas de freno y estado de discos', 'description' => 'Comprobación estado de pastillas de freno y estado de discos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Nivel de AdBLUE (Si lo llevase)', 'description' => 'Nivel de AdBLUE (Si lo llevase)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación del kit antipinchazos (en vehículos sin rueda de repuesto)', 'description' => 'Comprobación del kit antipinchazos (en vehículos sin rueda de repuesto)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Nivel líquido reductora y transmisiones', 'description' => 'Nivel líquido reductora y transmisiones'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión transmisiones y caja de transfer', 'description' => 'Revisión transmisiones y caja de transfer'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión correas de servicio (Tensión y estado)', 'description' => 'Revisión correas de servicio (Tensión y estado)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión cerraduras y cierre centralizado', 'description' => 'Revisión cerraduras y cierre centralizado'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión tiradores de puertas', 'description' => 'Revisión tiradores de puertas'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión de espejos retrovisores exteriores', 'description' => 'Revisión de espejos retrovisores exteriores'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión presión neumáticos incluido repuesto', 'description' => 'Revisión presión neumáticos incluido repuesto'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión de antena de radio', 'description' => 'Revisión de antena de radio'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión tapa de combustible', 'description' => 'Revisión tapa de combustible'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión, lunas', 'description' => 'Revisión, lunas'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión del cuadro de instrumentos y mediciones / nivel de carburante', 'description' => 'Revisión del cuadro de instrumentos y mediciones / nivel de carburante'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de luces y mandos y llave de arranque (pila de mando)', 'description' => 'Comprobación de luces y mandos y llave de arranque (pila de mando)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión de funcionamiento lunetas térmicas', 'description' => 'Revisión de funcionamiento lunetas térmicas'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de freno de mano (eficiencia y altura de palanca)', 'description' => 'Comprobación de freno de mano (eficiencia y altura de palanca)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación calefacción, aire acondicionado y mandos', 'description' => 'Comprobación calefacción, aire acondicionado y mandos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación airbags', 'description' => 'Comprobación airbags'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación parasoles y espejos interiores', 'description' => 'Comprobación parasoles y espejos interiores'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación ajustes de retrovisores', 'description' => 'Comprobación ajustes de retrovisores'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de tiradores de puertas y elevalunas', 'description' => 'Comprobación de tiradores de puertas y elevalunas'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación deñ bloqueo de las puertas', 'description' => 'Comprobación deñ bloqueo de las puertas'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de funcionamiento de radio, Bluetooth, GPS, tarjeta de datos', 'description' => 'Comprobación de funcionamiento de radio, Bluetooth, GPS, tarjeta de datos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación cinturones de seguridad (Limpieza y ajustes)', 'description' => 'Comprobación cinturones de seguridad (Limpieza y ajustes)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación reglajes asientos y estado de tapiceria', 'description' => 'Comprobación reglajes asientos y estado de tapiceria'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de luces interiores', 'description' => 'Comprobación de luces interiores'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación bandeja trasera tapa objetos', 'description' => 'Comprobación bandeja trasera tapa objetos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación tapas guantera y cerraduras', 'description' => 'Comprobación tapas guantera y cerraduras'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Revisión puertas traseras y laterales', 'description' => 'Revisión puertas traseras y laterales'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación estado de la caja de carga y protección de paneles de madera', 'description' => 'Comprobación estado de la caja de carga y protección de paneles de madera'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación estado del extintor, triángulos y chaleco reflectante', 'description' => 'Comprobación estado del extintor, triángulos y chaleco reflectante'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de accesorios (Enganche, Cabrestante, Estanterías y rejilla separadora)', 'description' => 'Comprobación de accesorios (Enganche, Cabrestante, Estanterías y rejilla separadora)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de herramientas (Gato, manivelas, etc.)', 'description' => 'Comprobación de herramientas (Gato, manivelas, etc.)'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Comprobación de documentación cotejada (Ficha técnica, Permiso de circulación y Póliza de seguro', 'description' => 'Comprobación de documentación cotejada (Ficha técnica, Permiso de circulación y Póliza de seguro'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Carpeta corporativa con manual de conductor y parte amistoso de accidente', 'description' => 'Carpeta corporativa con manual de conductor y parte amistoso de accidente'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Manual de instrucciones del fabricante y libro de garantía', 'description' => 'Manual de instrucciones del fabricante y libro de garantía'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Limpieza exterior', 'description' => 'Limpieza exterior'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Aspirado interior', 'description' => 'Aspirado interior'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Limpieza de asientos', 'description' => 'Limpieza de asientos'
            ],
            [
                'company_id' => Company::INVARAT,
                'question' => 'Limpieza tapicería', 'description' => 'Limpieza tapicería'
            ]
        ];
    }
}
