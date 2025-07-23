<?php

namespace App\Libraries\astro\hd;

use App\Controllers\BaseController;

class HumanDesign extends BaseController
{
    public function generateSubstructureInformationForPlanets($chart, $key)
    {
        $gateOrder = $this->getGateOrder(); // Assuming you have a method to get gate order
        $output = '';
        foreach ($chart[$key] as $planet => $chartPlanet) {
            $substructureData = $this->getSubstructureData(
                $chartPlanet['sign'], 
                $chartPlanet['degree'], 
                $chartPlanet['minutes'], 
                $chartPlanet['seconds']
            );
            
            $gate = $substructureData['gate'];
            $line = $substructureData['line'];
            $color = $substructureData['color'];
            $tone = $substructureData['tone'];
            $base = $substructureData['base'];

            $output .= '<tr><td>' . $planet . '</td><td>' . $gate . '</td><td>' . $line . '</td><td>' . $color . 
                       '</td><td>' . $tone . '</td><td>' . $base . '</td></tr>';
        }
        return $output;
    }

    public function generateFullSubstructureReport($chart)
    {
        $output = '<table><thead><tr><td colspan="6">Personality<hr></td></tr></thead><tbody>' .
                  '<tr><td>Planet</td><td>Gate</td><td>Line</td><td>Color</td><td>Tone</td><td>Base</td><tr>';
        $output .= $this->generateSubstructureInformationForPlanets($chart, 'Personality');
        $output .= '</tbody></table>';

        $output .= '<table><thead><tr><td colspan="6">Design<hr></td></tr></thead><tbody>' .
                   '<tr><td>Planet</td><td>Gate</td><td>Line</td><td>Color</td><td>Tone</td><td>Base</td><tr>';
        $output .= $this->generateSubstructureInformationForPlanets($chart, 'Design');
        $output .= '</tbody></table>';

        return $output;
    }

    public function index()
    {
        // Sample birth data
        $chart = [
            'Personality' => [
                'Planet1' => ['sign' => 'Aries', 'degree' => 20, 'minutes' => 15, 'seconds' => 30],
                // Add more planets...
            ],
            'Design' => [
                'Planet1' => ['sign' => 'Leo', 'degree' => 10, 'minutes' => 25, 'seconds' => 40],
                // Add more planets...
            ]
        ];

        $report = $this->generateFullSubstructureReport($chart);

        // You can return the report HTML or pass it to a view
        return $report;
    }

    // Add other helper methods here if needed
    private function getGateOrder()
    {
        // Implement logic to get gate order
        // Return an array of gate order
    }

    private function getSubstructureData($sign, $degrees, $minutes, $seconds)
    {
        // Implement logic to calculate substructure data
        // Return an array containing gate, line, color, tone, base
    }
}
