<?php
function return_publish_fields(){

    $bulk = '
<id2>'.  73645 . '</id2>
<idstr></idstr>
<judet>10</judet>
<localitate>13822</localitate>
<zona>750</zona>
<portal>1</portal>
<tiplocuinta>110</tiplocuinta>
<devanzare>1</devanzare>
<dataadaugare>1</dataadaugare>
<datamodificare>1</datamodificare>
<destinatie>466</destinatie>
<idnum></idnum>
<agent>51</agent>
<tipimobil>121</tipimobil>
<ansamblurezidential>0</ansamblurezidential>
<tipcompartimentare>26</tipcompartimentare>
<demisol>0</demisol><dotari>20 142 145</dotari>
<finisaje>55 56</finisaje>
<deinchiriat>0</deinchiriat>
<mansarda>0</mansarda>
<nrbucatarii>1</nrbucatarii>
<nrnivele>4</nrnivele>
<pretnegociabil>1</pretnegociabil>
<pretvanzare>125000</pretvanzare>
<monedavanzare>172</monedavanzare>
<patratecaroiaj>172</patratecaroiaj>
<etaj>47</etaj>   
<nrcamere>1</nrcamere>   
<tara>1048</tara>
<pretinchiriere>464000</pretinchiriere>
<monedainchiriere>172</monedainchiriere>
<vicii>
</vicii>
	<lang_vicii>Zm9hcnRlIHVyYXQ=</lang>
<pretinchiriereunitar>464000</pretinchiriereunitar>
<monedainchiriereunitar>172</monedainchiriereunitar>
<comisioncumparator>
</comisioncumparator>
<lang_comisioncumparator>Zm9hcnRlIHVyYXQ=</lang>
<structurarezistenta>138</structurarezistenta>
<subsol>0</subsol>
<regimhotelier>0</regimhotelier>
<pretfaratva>0</pretfaratva>
<utilitati>21 22 28 32 34 44 91</utilitati>
<caroiaj>29085525</caroiaj>
<imagini>
</imagini>
    <imagine></imagine>
    <imagine_descriere>YWljaSBhciBmaSBkZXNjcmllcmVhIGltYWdpbmlp</descriere>
';
    $tmp = explode('</',$bulk);
    foreach ($tmp as $k=>$b){
        $tag = extract_between($b,'<','>');
        if(strlen($tag[0])){
            $data[$tag[0]] = $tag[0];
        }

    }
    return $data;
}