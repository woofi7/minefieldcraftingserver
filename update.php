<?php
require 'saveData.php';
include('DOMParser/simple_html_dom.php');

$date = strftime("%m-%d-%Y", mktime(0, 0, 0, date('m'), date('d')-2, date('Y')));

function getAchievements($html) {
    $achievements = array();

    foreach($html->find('div[class=achievementStepDetails]') as $achievement) {

        //Fat boots
        if(preg_match('#Fat Boots#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/10000 kc\)#', $achievement->outertext, $result);
            $achievements["walkingDistance"][] = $result[1];
        }

        //Carpette Diem
        else if(preg_match('#Carpette Diem#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/666\)#', $achievement->outertext, $result);
            $achievements["death"][] = $result[1];
        }

        //Ancêtre et en Os
        else if(preg_match('#Ancêtre et en Os#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/12\)#', $achievement->outertext, $result);
            $achievements["seniority"][] = $result[1];
        }

        //Je chatte, donc je suis
        else if(preg_match('#Je chatte, donc je suis#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/10000\)#', $achievement->outertext, $result);
            $achievements["messagesSent"][] = $result[1];
        }

        //Insomniaque
        else if(preg_match('#Insomniaque#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/604800\)#', $achievement->outertext, $result);
            $achievements["connectionTime"][] = $result[1];
        }

        //FLÄRDFULL
        else if(preg_match('#FLÄRDFULL#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/123\)#', $achievement->outertext, $result);
            $achievements["bookshelfPlaced"][] = $result[1];
        }

        //Castle Crasher
        else if(preg_match('#Castle Crusher#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/500\)#', $achievement->outertext, $result);
            $achievements["cuboSize"][] = $result[1];
        }

        //Cobbel comme le jour
        else if(preg_match('#Cobbel comme le jour#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/100000\)#', $achievement->outertext, $result);
            $achievements["cobbleDig"][] = $result[1];
        }

        //CobbelBob Lennon
        else if(preg_match('#CobbelBob Lennon#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/10000\)#', $achievement->outertext, $result);
            $achievements["cobblePlaced"][] = $result[1];
        }

        //Moooon préééciieeeuuuuuux
        else if(preg_match('#Mooon préééciieeeuuuuux#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/100\)#', $achievement->outertext, $result);
            $achievements["diamondDig"][] = $result[1];
        }

        //Au début était la bouse
        else if(preg_match('#Au début était la bouse#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/100000\)#', $achievement->outertext, $result);
            $achievements["dirtDig"][] = $result[1];
        }

        //Chalutier
        else if(preg_match('#Chalutier#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/256\)#', $achievement->outertext, $result);
            $achievements["fishCaught"][] = $result[1];
        }

        //Musclor
        else if(preg_match('#Musclor#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/1000\)#', $achievement->outertext, $result);
            $achievements["obsiDig"][] = $result[1];
        }

        //Naincroyable
        else if(preg_match('#naincroyable#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/500000\)#', $achievement->outertext, $result);
            $achievements["stoneDig"][] = $result[1];
        }

        //You are a rolling stone
        else if(preg_match('#You are a rolling stone#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/102400\)#', $achievement->outertext, $result);
            $achievements["stonePlaced"][] = $result[1];
        }

        //Illuminati
        else if(preg_match('#Illuminati#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/7890\)#', $achievement->outertext, $result);
            $achievements["torchesPlaced"][] = $result[1];
        }

        //Reforestation
        else if(preg_match('#Reforestation#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/1234\)#', $achievement->outertext, $result);
            $achievements["treePlaced"][] = $result[1];
        }

        //Déforestation
        else if(preg_match('#Déforestation#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/1234\)#', $achievement->outertext, $result);
            $achievements["woodCut"][] = $result[1];
        }

        //Un gros pigeon
        else if(preg_match('#Un gros pigeon !#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/4000\)#', $achievement->outertext, $result);
            $achievements["riannonReputation"][] = $result[1];
        }

        //Je suis à bout
        else if(preg_match('#Je suis à bout#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/4000\)#', $achievement->outertext, $result);
            $achievements["boudumondeReputation"][] = $result[1];
        }


        //Baston
        else if(preg_match('#Baston !#', $achievement->outertext)) {
            preg_match('#\(([0-9]{1,})/4000\)#', $achievement->outertext, $result);
            $achievements["balhaizReputation"][] = $result[1];
        }

    }
    return $achievements;
}

function getLastPlayerPage($date) {
    $html = file_get_html("https://www.minefield.fr/forum/members/?lastvisit=" . $date . "&lastvisit_ltmt=mt&st=0");
    $html->find('ul a[title=Aller à la dernière page]');
    $lastPage = $html->find('a[title=Aller à la dernière page]', 0)->href;
    return substr($lastPage, strrpos($lastPage, "=") + 1) / 20;
}

$lastPage = getLastPlayerPage($date);

for ($page = 0; $page <= $lastPage; $page++) {

    $html = file_get_html("https://www.minefield.fr/forum/members/?lastvisit=" . $date . "&lastvisit_ltmt=mt&st=" . $page * 20);

    $count = -1;
    foreach ($html->find('strong a[title=Voir le profil]') as $element) {
        $count++;
        $playerData = array();

        $forumPseudo = $element->plaintext;
        $forumPseudo = htmlspecialchars($forumPseudo);
        $forumLink = $html->find('strong a[title=Voir le profil]', $count)->href;
        $forumProfileInformation = getForumProfileInformations($forumLink);
        if ($forumProfileInformation == null) {
            echo "\033[0;32m".($page * 20 + $count + 1)."\033[0;31m [Erreur] \033[0;0mInformations du profil forum \"$forumPseudo\"\n";
            continue;
        }
        $uuid = getUUID($forumProfileInformation["mcPseudo"][0]);
        if ($uuid == null) {
            echo "\033[0;32m".($page * 20 + $count + 1)."\033[0;31m [Erreur] \033[0;0mUUID du joueur \"$forumPseudo\"\n";
            continue;
        }
        $profileInformation = getProfileInformations($forumPseudo);
        if ($profileInformation == null) {
            echo "\033[0;32m".($page * 20 + $count + 1)."\033[0;31m [Erreur] \033[0;0mInformations du profil \"$forumPseudo\"\n";
            continue;
        }

        $playerData["playerNameList"][] = getPlayerNameList($uuid);

        $playerData["forumPseudo"][] =  $forumPseudo;
        $playerData["forumLink"][] = $forumLink;
        $playerData["UUID"][] = $uuid;

        $playerData = array_merge($playerData, $forumProfileInformation);
        $playerData = array_merge($playerData, $profileInformation);

        saveData($page * 20 + $count + 1, $playerData);
    }
}

function getForumProfileInformations($forumLink) {
    $informations = array();

    $html = file_get_html($forumLink);

    foreach($html->find('li[class=clear clearfix]') as $element) {
        if (preg_match('#Groupe#', $element->plaintext)) {
            preg_match('#\s*Groupe\s*(\w+)\s*#', $element->plaintext, $result);
            $informations["forumGroup"][] = $result[1];
        }
        else if (preg_match('#Messages#', $element->plaintext)) {
            preg_match('#\s*Messages\s*(\d*[ ]*\d*)\s*#', $element->plaintext, $result);
            $informations["forumMessages"][] = trim($result[1]);
        }
        else if (preg_match('#Titre#', $element->plaintext)) {
            preg_match('#\s*Titre\s*(\w+)\s*#', $element->plaintext, $result);
            $informations["rank"][] = $result[1];
        }
        else if (preg_match('#Pseudo minecraft#', $element->plaintext)) {
            preg_match('#\s*Pseudo minecraft\s*(\w+)\s*#', $element->plaintext, $result);
            $informations["mcPseudo"][] = $result[1];
        }
    }

    return $informations;
}

function getProfileInformations($forumPseudo) {
    $informations = array();

    $forumPseudo = str_replace("%", "", $forumPseudo);
    $forumPseudo = str_replace(" ", "%20", $forumPseudo);
    $forumPseudo = str_replace("..", "", $forumPseudo);
    $forumPseudo = str_replace("(", "%28", $forumPseudo);
    $forumPseudo = str_replace(")", "%29", $forumPseudo);

    $html = file_get_html("http://www.minefield.fr/profil/" . $forumPseudo);
    if (!$html) {
        return null;
    }
    if (!empty($html->find('div[id=profil_inconnu]'))) {
        return null;
    }

    $registrationDate = $html->find('li[class=li4] div[class=content]', 0)->plaintext;
    $lastConnection = $html->find('li[class=li5] div[class=content]', 0)->plaintext;
    $speciality = $html->find('li[class=li6] div[class=content]', 0)->plaintext;

    if ($lastConnection == "Jamais") {
        return null;
    }

    $lastConnection = str_replace('/', '-', $lastConnection);
    $lastConnection = date("Y-m-d", strtotime($lastConnection));
    $registrationDate = str_replace('/', '-', $registrationDate);
    $registrationDate = date("Y-m-d", strtotime($registrationDate));

    $achievements = getAchievements($html);

    $informations["lastConnection"][] = $lastConnection;
    $informations["registrationDate"][] = $registrationDate;
    $informations["speciality"][] = $speciality;
    $informations = array_merge($informations, $achievements);

    return $informations;
}

function getUUID($pseudo) {
    $content = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . urlencode($pseudo));
    $json = json_decode($content);

    if ($json) {
        return $json->id;
    }

    return null;
}

function getPlayerNameList($uuid) {
    return file_get_contents("https://api.mojang.com/user/profiles/".$uuid."/names", false);
}

function rankID($name) {
    switch ($name) {
        case "Vagabond":
            return 1;
        case "Paysan":
            return 2;
        case "Citoyen":
            return 3;
        case "Roi":
            return 4;
        case "Chevalier":
            return 5;
        case "Gouverneur":
            return 6;
        case "Noble":
            return 7;
        case "Reporter de Minefield":
            return 13;
        case "Villageois":
            return 14;
        default:
            return 0;
    }
}

function specialityID($name) {
    switch ($name) {
        case "Aventurier":
            return 1;
        case "Enchanteur":
            return 3;
        case "Armurier":
            return 4;
        case "Bûcheron":
            return 5;
        case "Fermier":
            return 6;
        case "Forgeron":
            return 7;
        case "Herboriste":
            return 8;
        case "Indigène à la con du Chaos":
            return 9;
        case "Ingénieur":
            return 10;
        case "Joaillier":
            return 11;
        case "Maçon":
            return 12;
        case "Menuisier":
            return 13;
        case "Mineur":
            return 14;
        case "Outilleur":
            return 15;
        case "Pêcheur":
            return 16;
        case "Tavernier":
            return 17;
        case "Tisserand":
            return 18;
        case "Souffleur de verre":
            return 19;
        default:
            return 2;
    }
}

function saveData($count, $playerData) {
    $database = new saveData;

    if ($database->isOnDatabase($playerData["UUID"][0])) {
        $database->updatePlayer($playerData);
        echo "\033[0;32m".$count."\033[0;36m [Update] \033[0;0mPlayer updated \"".$playerData['forumPseudo'][0]."\"\n";

    }
    else {
        $database->addPlayer($playerData);
        echo "\033[0;32m".$count."\033[0;36m [Add] \033[0;0mPlayer added \"".$playerData['forumPseudo'][0]."\"\n";
    }
}
