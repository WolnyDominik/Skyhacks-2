<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            width: 100%;
        }

        body * {
            text-align: justify;
            text-justify: inter-word;
        }
    </style>
</head>

<body>
    <?php
$dir    = './bonus';
$files1 = scandir($dir);
// print_r($files1);
array_shift($files1);
array_shift($files1);


foreach ($files1 as $key => $value){
    // var_dump($wyniki);
    // $plik= $dir."/".$value."/summary.txt";
    // $data = array();
    // $file=fopen($plik, "r");
    // flock($file, 1);
    // while(!feof($file)) {
    // array_push($data, fgets($file));
    // }
    // flock($file, 3);
    // fclose($file);
    // print_r($data);
    findFiles($dir."/".$value, $value);
}
function findFiles($path, $root){

    $files2 = scandir($path);
// print_r($files2);
$html = '
<?php


require_once("tcpdf_include.php");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", true);

// set document information




// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__)."/lang/eng.php")) {
    require_once(dirname(__FILE__)."/lang/eng.php");
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont("helvetica", "", 7);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents("/path/to/your/file.html");
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE --> 
<style>
 html{
    height: 287mm;
    width: 210mm;
}
    body {
        // margin: 15mm 5mm 5mm 0mm;
        height: 287mm;
        width: 200mm;   
            // display: flex;
            // flex-direction: row;
            // flex-wrap: wrap;
            // justify-content: flex-start;
            // align-items: baseline;
            // align-content: space-between;
        }

    body * {
        text-align: justify;
        text-justify: inter-word;
        box-sizing: border-box;
    }
    div{
        // float:left;
         display:flex;
            //  width: 100mm;
            //  align-items: center;
            //  justify-content: center;
            //  margin:1mm 0 1mm 0;
            // flex-direction: row;
            // flex-wrap: wrap;
            // justify-content: flex-start;
            // align-items: baseline;
            // align-content: space-between;
            //  font-size: 7mm;
            text-align:center;
    }
    img{

        width: 55mm;
        height: 55mm;
        padding-left: 25mm;
        padding-right: 25mm;
        margin: 10px;
    }
    h1{
    position: absolute;
    margin:auto;
    padding-left: 77mm;
    top: 8mm;
    text-align:center;
    }
    .grow{
        // flex-grow: 1;
    }
    footer{
    //     position: absolute;
    // margin:auto;
    // top: 267mm;
    // width: 200mm;   
    // height: 30mm;
    // padding-left: 70mm;
    text-align:center;
    }
    footer img{
        width: 200mm!important;   
        height: 80mm!important;
    }
</style>

<body>
<div ><img  width="60mm" height="20mm" margin-bottom="-80mm" src="logo.png" ></div>
<h1>For Sale</h1>
';
array_shift($files2);
array_shift($files2);

$wyniki=array(
    "This stunning two-story home is on a large lot in a hot neighborhood. From the open-
concept kitchen and living space to the large shaded backyard, there is plenty of room
for the whole family to enjoy. Recent updates include new carpeting upstairs and
stainless appliances. Situated in a family-friendly neighborhood near a great park, this
home is sure to go fast!
Available 17 September 2019 - Vita Properties are delighted to offer this brand newly
refurbished to an excellent standard is this beautiful two double bedroom second
floor apartment set within a conversion on one of St John Wood premier roads.
The apartment further features contemporary furnishings, modern fixtures and
fittings, spacious and bright open plan kitchen/reception room, en-suite bathroom,
family bathroom and is closely positioned for both the amenities and transport links of
Maida Vale and St John&#39;s Wood." ,

"Available immediately - A smart contemporary apartment in this award winning
modern development on the cusp of Primrose Hill. Located just moments from
Regents Park and Camden Lock, this apartment sits on the top floor (lift) and
comprises 1 bedroom, 1 bathroom, a fully fitted kitchen and large double reception
room with balcony. The apartment benefits from wooden floors, under floor heating,
intelligent halogen lighting. Viewings highly recommended.",

"Ajax &amp; Json Group estate agents are proud to present this one bedroom ground floor purpose
built flat. The property is being sold on a chain free basis. The property consists of a double
bedroom, a lounge/diner, a fully fitted kitchen as well as a family bathroom. The property also has
the added benefits of phone security entry system, communal gardens and allocated parking. The
property is ideally located just off of Lea Bridge Road. Access to a range of amenities such as
pubs, restaurants, shops and bars are all within walking distance to the property. With the new
Lea Bridge Road station open at the bottom of Lea Bridge Road access directly into Stratford and
the Olympic village is only a stones throw away. Access to Epping forest is a short walk in the
opposite direction and is ideal for country walks and bike rides. Call today to avoid certain
disappointment. Fitted phone point and power points."
,
"This spacious property is located on Shooters Hill and is always popular with the open spaces of
Eltham Common and Oxleas Woods very close along with the historic Severndroog Castle. The
accommodation comprises three good size bedroom all with fitted wardrobes, a bathroom with
separate WC, good sized lounge with balcony and a kitchen. Additional benefits from double
glazing, ample parking areas and green communal garden areas. This fantastic ground floor flat
will make an excellent investment for a buy to let investor or a first time buyer alike.Energy
Efficiency Rating S,this home is sure to go fast!"
,
"Impressive larger than average studio apartment situated within a well-kept purpose build block in
one of South East Londons up and coming locations.This apartment is positioned within close
proximity of the shopping amenities of Woolwich town centre offering a wide range of
supermarkets, shops as well as popular bars, restaurants. For the busy commuter, you are spoilt
with the fantastic transport facilities of Woolwich Dockyard as well as Woolwich Arsenal which
has links into London Bridge and Charing Cross as well as the DLR and Thames Clipper. The
arrival of the pending Cross Rail will also be a welcomed addition in Autumn of 2020.This well
presented apartment comprises bright and airy lounge, kitchen, bedroom with built in wardrobes
and a bathroom suite with bathtab.Additional benefits include double glazing, well maintained
communal gardens and off street parking. To fully appreciate this fantastic first time buy, an
internal viewing is highly recommended.Energy Efficiency Rating B."
,
"Positioned in the heart of Woolwich town centre is this impressive one bedroom apartment
located on the 2th floor of the ever popular Vista Building. Located in one of South East London&#39;s
up and coming areas is this bright and airy property is situated within close proximity of the
shopping amenities of Woolwich and Charlton offering a wide range of supermarkets, shops as
well as popular bars, restaurants and a doctors surgery. For the busy commuter, you are spoilt
with the fantastic transport facilities of Woolwich Arsenal which has links into London Bridge and
Charing Cross as well as the DLR that gets you into Canary Wharf, Liverpool Street and Bond
Street. Woolwich Dockyard Station is also only a short 4 minute walk away as well as the Cross
Rail being a welcomed addition in Autumn 2020.This delightful apartment comprises 14ft lounge
with open plan newly fitted kitchen and built in oven and hob, one bedroom and bathroom suite
with bath and full width mirror. Additional benefits include double glazing, a new boiler, off street
allocated parking and a private balcony with views.To fully appreciate this ideal first time buy, an
internal viewing is highly recommended.Energy Efficiency Rating B",

"Guide Price £200,000. In the midst of an exciting and transformative regeneration program, Bruce
Grove is at the heart of a vastly evolving area with attractive housing stock, excellent transport
links and superb amenities. Bruce Grove is the local overground station providing direct links to",


"London Liverpool Street, West End and City.Benefits include leasehold, entry phone system,
fitted kitchen, balcony, gas central heating (untested), double glazing (where stated).",

"A well presented one bedroom top floor purpose built apartment, with private balcony and
extended lease. Convenient for Plumstead and Woolwich High streets, local amenities and both
mainline stations. 12ft Living Room Modern Fitted Kitchen White Bathroom Suite"
,
"This bright and good sized apartment benefits from replacement double glazed windows,
separate kitchen, entryphone system, allocated parking space and is offered to the market chain
free. Properties in this location are perfect for first time buyers and investment purchasers and
this well maintained flat comes highly recommended. Energy Efficiency Rating C.TENURE:
Leasehold",

"This spacious property is located on Shooters Hill and is always popular with the open spaces of
Eltham Common and Oxleas Woods very close along with the historic Severndroog Castle. The
accommodation comprises three good size double bedrooms all with fitted wardrobes, a
bathroom with separate WC, good sized lounge with balcony and a kitchen. Additional benefits
from double glazing, ample parking areas and green communal garden areas. This fantastic
ground floor flat will make an excellent investment for a buy to let investor or a first time buyer
alike.Energy Efficiency Rating E",

"Accommodation is tastefully presented and briefly comprises 17&#39;5 x 14&#39;8 reception room,
separate fitted kitchen, a double bedroom with built in storage and a Juliet balcony overlooking
the communal gardens and a well-appointed bathroom. Benefits include a security entry phone
system, house manager, 24 hour emergency call system, visitors parking, lifts, a communal
garden and an entertainment room for residents.This superb apartment is suitable for residents
over 60 years, or if a couple one needs to be at least 60 and the other over 55 years old.Energy
Efficiency Rating: C",

"On the first floor enter via intercom to clean stairwells. The property briefly comprises hall,
kitchen, reception room, double bedroom and bathroom. In need of a general tidy but at this price
we dont expect to hear any grumbling. Its got a good healthy lease and has the benefit of no
chain. Interior: Living Room, Separate Fitted Kitchen, One Bedroom and Bathroom",

"We are delighted to present this beautiful and desirably generous 2 bedroom, 2 bathroom
maisonette flat located in close proximity Croydon Town Centre. The property offers ample living
space and comprises of a very practical kitchen, bright living room with a balcony overlooking
communal area and two large bedrooms, both benefiting from en-suite bathrooms.",

"REDUCED BY 10,000 FOR QUICK SALE! Ajax &amp; Json Estate Agency is proud to present this
delightful 1 bedroom ground floor flat in new development near Dollis Hill and Neasden zone 3
Jubilee Line Stations, several good bus routes and shopping centre. This charming flat features
double bedroom, spacious living and dining room, modern fitted kitchen, lovely tiled bathroom
with bath and shower attachment, gas central heating, double glazing, reserved parking space
and use of garden. Chain-free sale. Sole agents.",

"One bedroom period conversion apartment located on the 2nd floor of a converted victorian
house. Clifford Road is a residential road located off Portland Road. Norwood Junction train
station is within walking distance and has links to London Bridge and Victoria. Central Croydon,
with it&#39;s abundance of shops and amenities is one stop on the train or a short bus ride away.",

"Guide Price 250,000 - 275,000 Mann Estate Agents are proud to act as sole agents on this
spacious first floor two bedroom flat with BALCONY. Benefiting from generous accommodation,
excellent proportions and a fabulous location, this is a super first time buy in our opinion and a
great entry point for the London property market. The property is located on Bell Green Lane,
close to the shops and amenities of Sydenham and Bell Green and only 5 minutes from Lower
Sydenham …",

"Guide Price £200,000. In the midst of an exciting and transformative regeneration program, Bruce
Grove is at the heart of a vastly evolving area with attractive housing stock, excellent transport
links and superb amenities. Bruce Grove is the local overground station providing direct links to
London Liverpool Street, West End and City.Benefits include leasehold, entry phone system,
fitted kitchen, balcony, gas central heating (untested), double glazing (where stated).",

"Guide Price £250,000. Target Property are pleased to offer for sale this 2-Bedroom, Ground Floor
Maisonette with own Garden. Beverly Close N21 is well located to Green Lanes local shops,
supermarkets, restaurants as well as being within walking distance to Winchmore Hill Railway
Station offering easy access into Central London. The property requires a cosmetical
refurbishment throughout and would suit a cash buyer! Current lease 43 Years to extend lease
approx £73,000 plus legals …",

"Guide Price £209,995. PK Sales and Lettings are delighted to market this beautiful third floor one
bedroom flat available for sale in a secure gated development in West Thamesmead, London,
SE18This recently refurbished flat comprises of a modern, semi open plan kitchen spacious and
bright living room overlooking river Thames, great size bedroom and modern three piece
bathroom suite.This flat is available for sale with a designated underground parking space.This
will be a great purchase!");
    foreach ($files2 as $key => $value2){
       if( $key%2==0 && $value2!= "Thumbs.db"){
        $nazwaPliku = "/". $root.".php";
        $PathPliku = "/TCPDF-master/examples";
        $pathToImg = $root."/". $value2;
        // $myfile = fopen( $nazwaPliku, "w") or die("Unable to open file!");
        // $txt = "John Doe\n";
        // fwrite($myfile, $txt);
        // $txt = "Jane Doe\n";
        // fwrite($myfile, $txt);
        // fclose($myfile);
        // echo $value2 . "       <br>      ";
        $fileLocation = getenv("DOCUMENT_ROOT") . $PathPliku .$nazwaPliku;
        // echo $fileLocation;
        $file = fopen($fileLocation,"w");
        $zorro = time() ;
        $chill =intval(abs(((time()) . $key -1)%20));
        // echo var_dump($chill);
        $text = $wyniki[$chill];
        $html .= '';
        // echo var_dump($files2);
        if($key%6==0){
            $html .= ' 
            <div>';
            
        }
if($key%2==0){
        $html .= ' 
    
    <img src="../bonus/'.$pathToImg .'"> ';
       }
    
// else{
//     $html .= ' 
//     <div> <img src="../bonus/' .$pathToImg .'">
//     </div> ';
//        }
    }
    if($key%5==0 &&$key!=0 ){
        $html .= ' 
        </div>';
        
    }
    }
       $html .='<div class="grow">'.$text.'</div>
       <br>
       <footer></footer></body></html> 
EOF;
       
       $pdf->writeHTML($html, true, false, true, false, "");
       ob_end_clean();   
       $pdf->Output("' . $root.'.pdf", "I");
       
       ';
        fwrite($file,$html);
        fclose($file);
    
    

  echo '<p><a target="_blank" href="'.$PathPliku.'.'.$nazwaPliku.'">Open PDF '.$nazwaPliku.'</a></p>';
  echo "\n";
}
?>


</body>

</html>