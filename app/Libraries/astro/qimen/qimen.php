<?php

namespace app\Libraries\astro\qimen;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use DateTime;
use Moontoast\Math\BigNumber;

class QiMenDunJiaController extends BaseController
{
    private $datetime;
    private $lunarDate;
    private $yearStemBranch;
    private $monthStemBranch;
    private $dayStemBranch;
    private $hourStemBranch;
    private $qiMenDunJiaChart;

    private $heavenlyStems = ['Jia', 'Yi', 'Bing', 'Ding', 'Wu', 'Ji', 'Geng', 'Xin', 'Ren', 'Gui'];
    private $earthlyBranches = ['Zi', 'Chou', 'Yin', 'Mao', 'Chen', 'Si', 'Wu', 'Wei', 'Shen', 'You', 'Xu', 'Hai'];

    public function __construct(DateTime $datetime)
    {
        $this->datetime = $datetime;
        $this->calculateLunarDate();
        $this->calculateHeavenlyStemsEarthlyBranches();
        $this->generateQiMenDunJiaChart();
    }

    private function calculateLunarDate()
    {
        // Placeholder for actual lunar date calculation
        $this->lunarDate = 'Placeholder Lunar Date';
    }

    private function getHeavenlyStem($year)
    {
        return $this->heavenlyStems[($year - 4) % 10];
    }

    private function getEarthlyBranch($year)
    {
        return $this->earthlyBranches[($year - 4) % 12];
    }

    private function calculateHeavenlyStemsEarthlyBranches()
    {
        $year = (int)$this->datetime->format('Y');
        $this->yearStemBranch = $this->getHeavenlyStem($year) . ' ' . $this->getEarthlyBranch($year);
        // Placeholder for actual month, day, and hour stem-branch calculations
        $this->monthStemBranch = 'Ren Xu';  // Example placeholder
        $this->dayStemBranch = 'Bing Chen';  // Example placeholder
        $this->hourStemBranch = 'Ding Si';  // Example placeholder
    }

    private function generateQiMenDunJiaChart()
    {
        $this->qiMenDunJiaChart = [
            'Palace 1' => ['Door' => 'Life', 'Star' => 'Peng', 'God' => 'Chief'],
            'Palace 2' => ['Door' => 'Death', 'Star' => 'Chong', 'God' => 'Snake'],
            'Palace 3' => ['Door' => 'Open', 'Star' => 'Rui', 'God' => 'Tiger'],
            'Palace 4' => ['Door' => 'Harm', 'Star' => 'Ying', 'God' => 'Bird'],
            'Palace 5' => ['Door' => 'Rest', 'Star' => 'Qin', 'God' => 'Turtle'],
            'Palace 6' => ['Door' => 'Scenery', 'Star' => 'Ren', 'God' => 'Dragon'],
            'Palace 7' => ['Door' => 'Delusion', 'Star' => 'Fu', 'God' => 'Phoenix'],
            'Palace 8' => ['Door' => 'Shock', 'Star' => 'Xin', 'God' => 'Warrior'],
            'Palace 9' => ['Door' => 'Scenery', 'Star' => 'Zhu', 'God' => 'Turtle']
        ];
    }

    public function index()
    {
        return view('qimen_chart', [
            'gregorianDate' => $this->datetime->format('Y-m-d H:i'),
            'lunarDate' => $this->lunarDate,
            'yearStemBranch' => $this->yearStemBranch,
            'monthStemBranch' => $this->monthStemBranch,
            'dayStemBranch' => $this->dayStemBranch,
            'hourStemBranch' => $this->hourStemBranch,
            'qiMenDunJiaChart' => $this->qiMenDunJiaChart,
        ]);
    }
}
