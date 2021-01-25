<?php

// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * External Web Service WSILB
 *
 * @package    localwsilb
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");

class local_wsilb_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_available_courses_parameters() {
        return new external_function_parameters(
                array('tipocurso' => new external_value(PARAM_TEXT, 'Tipo de cursos que se deseja retornar. O padrão é ST (Sem Tutoria)', VALUE_DEFAULT, 'ST'))
        );
    }

    /**
     * Returns the courses as JSON
     * @return string welcome message
     */
    public static function get_available_courses($tipocurso = 'ST') {
        global $USER;

        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::get_available_courses_parameters(),
                array('tipocurso' => $tipocurso));

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = get_context_instance(CONTEXT_USER, $USER->id);
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        // if (!has_capability('moodle/user:viewdetails', $context)) {
        //     throw new moodle_exception('cannotviewprofile');
        // }


        $obj = new StdClass();

        $curso1 = array(
            "nome" => 'Assédio Moral e Sexual no Trabalho',
            "ch" => "6", 
            "duracao" => 'Até 60 dias', 
            "descricao" => 'Debater abertamente sobre Assédio Moral e Sexual no Trabalho visa melhorar as condições de trabalho e as relações entra os trabalhadores, melhorando, assim a qualidade de vida dos indivíduos e a sua produtividade. Tornar o ambiente de trabalho livre de qualquer prática ofensiva é a meta principal.',
            "imagem" => "https://saberes.senado.leg.br/pluginfile.php/4864928/course/overviewfiles/%C3%8Dcone%20Ass%C3%A9dio%20Moral%20e%20Sexual%20no%20trabalho.%20.png", 
            "link_saberes" => 'https://saberes.senado.leg.br/course/view.php?id=1757'
        );

        $curso2 = array(
            "nome" => 'Dialogando sobre a Lei Maria da Penha',
            "ch" => "60",
            "duracao" => "Até 60 dias",
            "descricao" => 'Contribuir para a redução da cultura da violência doméstica e familiar que atinge as mulheres, por meio do estudo, reflexão e diálogo sobre a Lei Maria da Penha, uma das principais ferramentas legislativas de atuação na assistência, prevenção e erradicação desse fenômeno social complexo e multifacetado que subtrai os direitos das mulheres a uma vida plena e sem violência.',
            "imagem" => "https://saberes.senado.leg.br/pluginfile.php/4862374/course/overviewfiles/Maria%20da%20Penha-min.png", 
            "link_saberes" => 'https://saberes.senado.leg.br/course/view.php?id=1731'
        );

        $cursos= array($curso1, $curso2);


        $obj->tipo='ST';
        $obj->cursos = $cursos;

        $json = json_encode($obj);

        return $json; //params['tipocurso'] . $USER->firstname ;;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_available_courses_returns() {
        return new external_value(PARAM_TEXT, 'JSON com os cursos disponíveis');
    }



}
