
<?php

class SportFieldController extends Controller
{
    public function addSportField()
    {
        return $this->view('sport_field/add');
    }

    public function storeSportField()
    {
        var_dump($_POST);
    }
}
?>