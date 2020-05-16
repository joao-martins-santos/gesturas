<?php

namespace App\Http\Controllers\Vet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetVetAssistance;
use App\Pet;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    
    public function index(){
        $pets_assistance = PetVetAssistance::with('pet')->where('vet_id', auth()->user()->id)->get();
        return view('vet.monitoring.index', compact('pets_assistance'));
    }

    public function details($id, $dt_ini=null, $dt_fim=null){
        $dataInicial = date("Y-m-d 00:00:00", strtotime( date("Y-m-d") . ' - 7 days'));
        $dataFinal   = date("Y-m-d 00:00:00");

        if ( !is_null($dt_ini) && !is_null($dt_fim) ) {
            $dataInicial = $dt_ini . ' 00:00:00';
            $dataFinal   = $dt_fim . ' 23:59:59';
        }

        $pet = Pet::find($id);

        $temperaturas = DB::table('iot_temp_umid')->select('*')->whereRaw("codigo = '" . $pet->cod_collar . "' and dt_hr_inicio>= '".$dataInicial."' and dt_hr_fim <= '".$dataFinal."'" )->get();
        $luminosidade = DB::table('iot_luminosidade')->select( DB::raw('sum(escuro)+sum(sombra)+sum(claro) as total'), DB::raw('sum(escuro) as escuro'),DB::raw('sum(sombra) as sombra'),DB::raw('sum(claro) as claro') )->whereRaw("codigo = '" . $pet->cod_collar . "' and dt_hr_inicio>= '".$dataInicial."' and dt_hr_fim <= '".$dataFinal."'" )->first();
        $passos       = DB::table('iot_passos')->select( DB::raw('sum(qtd) as qtd'))->whereRaw("codigo = '" . $pet->cod_collar . "' and dt_hr_inicio>= '".$dataInicial."' and dt_hr_fim <= '".$dataFinal."'" )->first();
        $posicao      = DB::table('iot_posicoes')->select( DB::raw('sum(sentado)+sum(empe)+sum(deitado) as total'), DB::raw('sum(sentado) as sentado'), DB::raw('sum(empe) as empe'), DB::raw('sum(deitado) as deitado') )->whereRaw("codigo = '" . $pet->cod_collar . "' and dt_hr_inicio>= '".$dataInicial."' and dt_hr_fim <= '".$dataFinal."'" )->first();

        $datas        = array('inicial'=> date("d/m/Y",strtotime($dataInicial)), 'final'=>date("d/m/Y",strtotime($dataFinal)));

        if ( !is_null($passos->qtd) ) {
            $num = ($passos->qtd/10000);
            $dadosGerais['Passo'] = (object)array( 'passos'=>$passos->qtd, 'minutos'=>($num*30), 'calorias'=>($num*500) );
        } else {
            $dadosGerais['Passo'] = (object)array('passos'=>0,'minutos'=>0,'calorias'=>0);
        }

        if ( !is_null($posicao->total) ) {
            $dadosGerais['Posicao'] = (object)array('sentado'     =>number_format(($posicao->sentado/$posicao->total) * 100, 2, '.',''), 
                                                    'empe'        =>number_format(($posicao->empe/$posicao->total)* 100, 2, '.',''),
                                                    'deitado'     =>number_format(($posicao->deitado/$posicao->total)*100, 2, '.',''),
                                                    'sentadoHoras'=>sprintf('%02d:%02d', (int) number_format($posicao->sentado/60, 2, '.',''), fmod(number_format($posicao->sentado/60, 2, '.',''), 1) * 60), 
                                                    'empeHoras'   =>sprintf('%02d:%02d', (int) number_format($posicao->empe/60, 2, '.',''), fmod(number_format($posicao->empe/60, 2, '.',''), 1) * 60),
                                                    'deitadoHoras'=>sprintf('%02d:%02d', (int) number_format($posicao->deitado/60, 2, '.',''), fmod(number_format($posicao->deitado/60, 2, '.',''), 1) * 60),
                                                    'totalHoras'  =>number_format($posicao->total/60, 2, '.',''),
                                                    );
        } else {
            $dadosGerais['Posicao'] = (object)array('sentado'=>0,'empe'=>0,'deitado'=>0,'sentadoHoras'=>0,'empeHoras'=>0,'deitadoHoras'=>0,'totalHoras'=>0);
        }

        if ( !is_null($luminosidade->total) ) {
            $dadosGerais['Luminosidade'] = (object)array('escuro'=>number_format(($luminosidade->escuro/$luminosidade->total)*100, 1, '.',''), 
                                                         'claro' =>number_format(($luminosidade->claro/$luminosidade->total)*100, 1, '.',''),
                                                         'sombra'=>number_format(($luminosidade->sombra/$luminosidade->total)*100, 1, '.',''));
        } else {
            $dadosGerais['Luminosidade'] = (object)array('escuro'=>0,'claro'=>0,'sombra'=>0);
        }

        $totalTemp = 0;
        $totalUmid = 0;
        if ( count($temperaturas)>0 ){
            foreach($temperaturas as $temperatura) {
                $json_temp[] = array('year'=>$temperatura->dt_hr_inicio, 'value'=> (float)$temperatura->temp );
                $totalTemp += $temperatura->temp;
                $totalUmid += $temperatura->umid;
            }
            //$json_temp      = $json_temp;
            $dadosGerais['Temperatura']  = (object)array('Temp'=>number_format($totalTemp/count($temperaturas),1, '.',''), 'Umid'=>number_format(($totalUmid/count($temperaturas)),1, '.','') );
        } else {
            $json_temp[]                 = array('year'=>0, 'value'=>0);
            $dadosGerais['Temperatura']  = (object)array('Temp'=>0, 'Umid'=>0 );
        }
        
        return view('vet.monitoring.details', compact('pet', 'json_temp', 'dadosGerais', 'datas'));
    }


    public function card($id, $dt_ini=null, $dt_fim=null){
        $pet = Pet::find($id);
        return view('vet.monitoring.card', compact('pet'));
    }

    public function history($id, $dt_ini=null, $dt_fim=null){
        $pet = Pet::find($id);

        return view('vet.monitoring.history', compact('pet', 'json_temp', 'luminosidades', 'passos', 'posicoes', 'dadosGerais'));
        die('history');
    }
 


}
