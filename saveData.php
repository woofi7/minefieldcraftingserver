<?php

class saveData
{
    private $database;

    function __construct() {
        $this->connectDatabase();
    }

    function __destruct()
    {
        $this->disconnectDatabase();
    }

    private function connectDatabase() {
        try {
            $dsn = 'mysql:host=woofi7.com;dbname=MfCrafting';
            $user = 'woofi7';
            $password = '***REMOVED***';

            $this->database = new PDO($dsn, $user, $password);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
        }
    }

    private function disconnectDatabase() {
        $this->database = null;
    }

    function updatePlayer($data) {
        try {
            $sql = 'UPDATE `PlayerList`
                     SET    `PseudoIG` = :playerNameList,
                            `PseudoForum` = :forumPseudo,
                            `Rank` = :rank,
                            `Speciality` = :speciality,
                            `LastConnection` = :lastConnection,
                            `ForumGroup` = :forumGroup
                     WHERE  `UUID` = :uuid';

            $update = $this->database->prepare($sql);
            $update->execute(array(':playerNameList' => $data["playerNameList"][0],
                ':forumPseudo' => $data["forumPseudo"][0],
                ':rank' => rankID($data["rank"][0]),
                ':speciality' => specialityID($data["speciality"][0]),
                ':lastConnection' => $data["lastConnection"][0],
                ':forumGroup' => $data["forumGroup"][0],
                ':uuid' => $data["UUID"][0]));
        }
        catch (PDOException $e) {
            echo 'Échec lors de la connexion, update player: ' . $e->getMessage();
            die();
        }

        try{
            $sql = 'UPDATE `Achievements`
                     SET    `WalkingDistance` = :walkingDistance,
                            `Death` = :death,
                            `Seniority` = :seniority,
                            `MessagesSent` = :messagesSent,
                            `ConnectionTime` = :connectionTime,
                            `BookshelfPlaced` = :bookshelfPlaced,
                            `CuboSize` = :cuboSize,
                            `CobbleDig` = :cobbleDig,
                            `CobblePlaced` = :cobblePlaced,
                            `DiamondDig` = :diamondDig,
                            `DirtDig` = :dirtDig,
                            `FishCaught` = :fishCaught,
                            `ObsiDig` = :obsiDig,
                            `StoneDig` = :stoneDig,
                            `StonePlaced` = :stonePlaced,
                            `TorchesPlaced` = :torchesPlaced,
                            `TreePlaced` = :treePlaced,
                            `WoodCut` = :woodCut,
                            `RiannonReputation` = :riannonReputation,
                            `BoudumondeReputation` = :boudumondeReputation,
                            `BalhaizReputation` = :balhaizReputation
                     WHERE  `playerId` = (SELECT `id` FROM `PlayerList` WHERE `UUID` = :uuid)';

            $update = $this->database->prepare($sql);
            $update->execute(array(':walkingDistance' => $data["walkingDistance"][0],
                ':death' => $data["death"][0],
                ':seniority' => $data["seniority"][0],
                ':messagesSent' => $data["messagesSent"][0],
                ':connectionTime' => $data["connectionTime"][0],
                ':bookshelfPlaced' => $data["bookshelfPlaced"][0],
                ':cuboSize' => $data["cuboSize"][0],
                ':cobbleDig' => $data["cobbleDig"][0],
                ':cobblePlaced' => $data["cobblePlaced"][0],
                ':diamondDig' => $data["diamondDig"][0],
                ':dirtDig' => $data["dirtDig"][0],
                ':fishCaught' => $data["fishCaught"][0],
                ':obsiDig' => $data["obsiDig"][0],
                ':stoneDig' => $data["stoneDig"][0],
                ':stonePlaced' => $data["stonePlaced"][0],
                ':torchesPlaced' => $data["torchesPlaced"][0],
                ':treePlaced' => $data["treePlaced"][0],
                ':woodCut' => $data["woodCut"][0],
                ':riannonReputation' => $data["riannonReputation"][0],
                ':boudumondeReputation' => $data["boudumondeReputation"][0],
                ':balhaizReputation' => $data["balhaizReputation"][0],
                ':uuid' => $data["UUID"][0]));
        }
        catch (PDOException $e) {
            echo 'Échec lors de la connexion, update achievements : ' . $e->getMessage();
            die();
        }

        return true;
    }

    function addPlayer($data) {
        try {
            $sql = 'INSERT INTO `PlayerList` (UUID, PseudoIG, PseudoForum, Rank, Speciality, RegistrationDate, LastConnection, ForumLink, ForumGroup)
                    VALUES (:uuid, :pseudoIG, :pseudoForum, :rank, :speciality, :registrationDate, :lastConnection, :forumLink , :forumGroup)';
            $stmt = $this->database->prepare($sql);
            $stmt->execute(array(':uuid' => $data["UUID"][0],
                ':pseudoIG' => $data["playerNameList"][0],
                ':pseudoForum' => $data["forumPseudo"][0],
                ':rank' => rankID($data["rank"][0]),
                ':speciality' => specialityID($data["speciality"][0]),
                ':registrationDate' => $data["registrationDate"][0],
                ':lastConnection' => $data["lastConnection"][0],
                ':forumLink' => $data["forumLink"][0],
                ':forumGroup' => $data["forumGroup"][0]));


            $sql = 'INSERT INTO `Achievements` (playerId, WalkingDistance, Death, Seniority, MessagesSent, ConnectionTime, BookshelfPlaced, CuboSize, CobbleDig, CobblePlaced, DiamondDig, DirtDig, ObsiDig, StoneDig, StonePlaced, TorchesPlaced, TreePlaced, WoodCut, RiannonReputation, BoudumondeReputation, BalhaizReputation, FishCaught)
                    VALUES ((SELECT `id` FROM `PlayerList` WHERE `UUID` = :uuid), :walkingDistance, :death, :seniority, :messagesSent, :connectionTime, :bookshelfPlaced, :cuboSize, :cobbleDig, :cobblePlaced, :diamondDig, :dirtDig, :obsiDig, :stoneDig, :stonePlaced, :torchesPlaced, :treePlaced, :woodCut, :riannonReputation, :boudumondeReputation, :balhaizReputation, :fishCaught)';
            $stmt = $this->database->prepare($sql);
            $stmt->execute(array(':uuid' => $data["UUID"][0],
                ':walkingDistance' => $data["walkingDistance"][0],
                ':death' => $data["death"][0],
                ':seniority' => $data["seniority"][0],
                ':messagesSent' => $data["messagesSent"][0],
                ':connectionTime' => $data["connectionTime"][0],
                ':bookshelfPlaced' => $data["bookshelfPlaced"][0],
                ':cuboSize' => $data["cuboSize"][0],
                ':cobbleDig' => $data["cobbleDig"][0],
                ':cobblePlaced' => $data["cobblePlaced"][0],
                ':diamondDig' => $data["diamondDig"][0],
                ':dirtDig' => $data["dirtDig"][0],
                ':obsiDig' => $data["obsiDig"][0],
                ':stoneDig' => $data["stoneDig"][0],
                ':stonePlaced' => $data["stonePlaced"][0],
                ':torchesPlaced' => $data["torchesPlaced"][0],
                ':treePlaced' => $data["treePlaced"][0],
                ':woodCut' => $data["woodCut"][0],
                ':riannonReputation' => $data["riannonReputation"][0],
                ':boudumondeReputation' => $data["boudumondeReputation"][0],
                ':balhaizReputation' => $data["balhaizReputation"][0],
                ':fishCaught' => $data["fishCaught"][0]));
        }
        catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
            die();
        }
    }

    function isOnDatabase($uuid) {
        try {
            $pdo = $this->database->prepare("SELECT `UUID` FROM `PlayerList` WHERE `UUID` = :UUID");
            $pdo->bindValue('UUID', $uuid);
            $pdo->execute();
            return $pdo->fetch();
        }
        catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
            die();
        }
    }
}