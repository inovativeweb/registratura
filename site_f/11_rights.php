<?php




function return_users_filiala($user_id)

{    global $users_all,$filiale_asoc;

    $brokers = array();

$current = $users_all[$user_id];



foreach ($filiale_asoc as $k=>$v)
{
	if($v['filiala_id']==$current['filiala_id'])
	{
	$all_asoc[]=$v['id'];	
	}
	
}
//prea($all_asoc);

        foreach ($users_all as $id=>$u){

                if($current['access_level'] == 2 and $current['asoc_id'] == $u['asoc_id'] and $u['access_level'] == 1){

                    $brokers[$u['id']] = $u['id'];

                }
                elseif($current['access_level'] == 3 and in_array($u['asoc_id'],$all_asoc)  and ($u['access_level'] == 1 || $u['access_level'] == 2)){

                    $brokers[$u['id']] = $u['id'];

                }
                 elseif($current['access_level'] > 9){

                    $brokers[$u['id']] = $u['id'];

                }

                elseif($current['access_level'] == 1 and $current['id'] == $u['id']){

                    $brokers[$u['id']] = $u['id'];

                }

        }

      return $brokers;

}




function return_users_agentie($user_id)

{    global $users_all;

    $brokers = array();

$current = $users_all[$user_id];

        foreach ($users_all as $id=>$u){

                if($current['access_level'] == 2 and $current['asoc_id'] == $u['asoc_id'] and $u['access_level'] == 1){

                    $brokers[$u['id']] = $u['id'];

                } elseif($current['access_level'] > 9){

                    $brokers[$u['id']] = $u['id'];

                }

                elseif($current['access_level'] == 1 and $current['id'] == $u['id']){

                    $brokers[$u['id']] = $u['id'];

                }

        }

        return $brokers;

}

function has_right($doc_id,$type){ global $vanzari_all,$cumparatori_all,$user_id_login,$access_level_login;

    $agentie = return_users_agentie($user_id_login);


    $filiala = return_users_filiala($user_id_login);
//prea($filiala);
  //  prea($agentie);

    if($type == 'vanzare') {

	if ($doc_id==0) return true;

        if (in_array($vanzari_all[$doc_id]['uid'],$agentie) or  $vanzari_all[$doc_id]['uid'] == $user_id_login or $access_level_login > 9 or ($access_level_login == 3 and in_array($vanzari_all[$doc_id]['uid'],$filiala))) {

           

            return true;

        } else {

            return false;

        }

    }

    if($type == 'cumparator') {

       // prea($cumparatori_all[$doc_id]);

        if (in_array($cumparatori_all[$doc_id]['business_broker'],$agentie) or  $cumparatori_all[$doc_id]['business_broker'] == $user_id_login or $access_level_login > 9 or ($access_level_login == 3 and in_array($cumparatori_all[$doc_id]['business_broker'],$filiala)) ) {

            return true;

        } else {

            return false;

        }

    }

}