function raz_history()
{

    $('#btnn').detach();
    $('#table').load('/history/reset', function() {//AJAX           
    });
}




function actuator()
{


    bootbox.dialog("<br><div class=\"pagination-centered\"><strong><h3>All scenarios will be deleted!<br> Do you really want to erase?</h3></strong></div><br>", [{
            "label": "<strong><br><h3>YES!</h3><br></strong>",
            "class": "btn-success btn-large btn-block",
            "callback": function() {
                //code
                location.href = "/api/actuator";
            }
        }, {
            "label": "<strong><br><h3>NO !</h3><br></strong>",
            "class": "btn-danger btn-large btn-block",
            "callback": function() {
                //code
            }
        }]);



}

function EditmemberAjax(name, id, psw, adult, admin)
{
    document.getElementById('form_members').style.display = 'none';
    if (document.getElementById('form_edit').style.display == 'none')
    {
        if (adult == "adult") {
            document.getElementById("checkboxAdult2").checked = true;
        }
        else
            document.getElementById("checkboxAdult2").checked = false;

        if (admin == "1")
            document.getElementById("checkboxAdmin").checked = true;
        else
            document.getElementById("checkboxAdmin").checked = false;

        document.getElementById('form_edit').style.display = 'block';
        document.getElementById('h4').innerHTML = name;
        document.getElementById('Pswd3').value = psw;
        document.getElementById('Pswd4').value = psw;
        document.getElementById('Name1').value = name;
        document.getElementById('inpHide').value = id;

    }
    else {
        document.getElementById('form_edit').style.display = 'none';
    }

}


function EditMembers() {

    //set class name to nothing
    document.getElementById("Name1").className = "";
    document.getElementById("Pswd1").className = "";
    document.getElementById("Pswd2").className = "";

    //data storage
    CurrName = document.getElementById("h4").innerHTML;
    Name = document.getElementById("Name1").value;
    Pswd1 = document.getElementById("Pswd3").value;

    Pswd2 = document.getElementById("Pswd4").value;
    id = document.getElementById("inpHide").value;
    checkboxAdult = document.getElementById("checkboxAdult2").checked;
    checkboxAdmin = document.getElementById("checkboxAdmin").checked;

    //form secure
    if ((document.getElementById('Pswd3').value != document.getElementById('Pswd4').value) || (Name == "") || (Pswd1 == "")) {

        //if password and other password different
        if ((document.getElementById('Pswd3').value != document.getElementById('Pswd4').value) || (Pswd1 == "")) {
            document.getElementById("ErrorPswd3").className = "control-group error";
            document.getElementById("ErrorPswd4").className = "control-group error";
        }


        //if name empty
        if (Name == "") {
            document.getElementById("ErrorNameUser").className = "control-group error";
        }



    } else {

        document.getElementById('form_edit').style.display = 'none';

        oldname = document.getElementById('page').innerHTML.trim();

        if (CurrName == oldname) {
            document.getElementById('page').innerHTML = Name;
        }


        $('#tableUser').load('/Members/edition?Name=' + Name + '&Pass=' + Pswd1 + '&Pass2=' + Pswd2 + '&checkboxAd=' + checkboxAdult + '&Id=' + id + '&CurrName=' + CurrName + '&checkboxAdmin=' + checkboxAdmin, function() {//AJAX           

        });
    }
}

function validateForm() {

    var retour = true;

    //set css design to nothing
    document.getElementById("ErrorPswd1").className = "";
    document.getElementById("ErrorName").className = "";


    //test secure form
    if (document.getElementById('Name').value == '')//secure name
    {

        document.getElementById('error').innerHTML = "Please fill in all fields";
        document.getElementById("ErrorName").className = "control-group error";
        retour = false;
    }
    if (document.getElementById('Pswd1').value == '')//secure password
    {
        document.getElementById('error').innerHTML = "Please fill in all fields";
        document.getElementById("ErrorPswd1").className = "control-group error";//design css for warning error
        retour = false;
    }

    return retour;
}

function validateFormEdit()
{

    //set css design to default
    document.getElementById("Name").className = "";
    document.getElementById("Pswd1").className = "";
    document.getElementById("Pswd2").className = "";

    //data storage
    Name = document.getElementById("Name").value;
    Age = document.getElementById("select01").value;
    Pswd1 = document.getElementById("Pswd1").value;
    Pswd2 = document.getElementById("Pswd2").value;

    //apply default css
    if (document.getElementById('Pswd1').value == document.getElementById('Pswd2').value) {
        document.getElementById("ErrorPswd1").className = "";
        document.getElementById("ErrorPswd2").className = "";
    }
    else {

        return false;

    }

    //secure form
    if ((document.getElementById('Pswd1').value != document.getElementById('Pswd2').value) || (Name == "")) {

        //secure if different password
        if (document.getElementById('Pswd1').value != document.getElementById('Pswd2').value) {
            document.getElementById("ErrorPswd1").className = "control-group error";
            document.getElementById("ErrorPswd2").className = "control-group error";
        }

        //secure if name empty
        if (Name == "") {
            document.getElementById("ErrorNameUser").className = "control-group error";
        }

        return false;


    } else {

        document.getElementById('form_edit').style.display = 'none';

        //$('#info').load('/profile/ajInfo?Name='+Name+'&Age='+Age+'&Pswd1='+Pswd1+'&Pswd2='+Pswd2, function() {//AJAX

        //});
        document.getElementById("page").innerHTML = Name;
        return true;
    }

}

function refresh()
{



    $('#add-regular').load('/History/Notification', function() {//AJAX           

    });
    setTimeout("refresh()", 1000);

}


function validateFormNewScenar()
{

    var retour = true;

    //data storage (name of the scenario and its description)
    nomScenar = document.getElementById("scenario_name").value;
    descScenar = document.getElementById("description").value;

    //set css design to default / remove design error
    document.getElementById("ErrorScenarName").className = "";
    document.getElementById("ErrorDesc").className = "";

    if (document.getElementById("theValue").value <= 0)
        retour = false;

    //secure form   
    if ((nomScenar == '') || (description == '')) {
        //scenario name secure
        if (nomScenar == '') {
            document.getElementById("ErrorScenarName").className = "control-group error";
        }
        //description secure
        if (descScenar == '') {
            document.getElementById("ErrorDesc").className = "control-group error";
        }

        retour = false;
    }
    return retour;

}

function ShowEdit()
{

    if (document.getElementById('form_edit').style.display == 'none') {

        //display form
        document.getElementById('form_edit').style.display = 'block';

        //set css design to default / remove css design warning
        document.getElementById('ErrorNameUser').className = "";
        document.getElementById('ErrorPswd1').className = "";
        document.getElementById('ErrorPswd2').className = "";

        //remove content of fields
        //document.getElementById('Name').value="";
        document.getElementById('Pswd1').value = "";
        document.getElementById('Pswd2').value = "";

    } else
        //hide form
        document.getElementById('form_edit').style.display = 'none';
}

function FormMember()
{
    //hide form
    document.getElementById('form_edit').style.display = 'none';

    //display form
    if (document.getElementById('form_members').style.display == 'none') {

        //display
        document.getElementById('form_members').style.display = 'block';

        //display nothing when click on "Add a member"
        //css design default
        document.getElementById("ErrorName").className = "";
        document.getElementById("ErrorPswd1").className = "";
        document.getElementById("ErrorPswd2").className = "";

        //remove content of fields
        document.getElementById("Name").value = "";
        document.getElementById("Pswd1").value = "";
        document.getElementById("Pswd2").value = "";
    } else
        //hide form
        document.getElementById('form_members').style.display = 'none';
}

function DeleteMembre()
{
    alert('Member deleted !');
}

function add_action()
{
    //data storage
    var ni = document.getElementById('actions_zone');
    var newdiv = document.createElement('div');
    var numi = document.getElementById('theValue');

    var num = (document.getElementById('theValue').value - 1) + 2;

    numi.value = num;
    var divIdName = 'mon' + num + 'Div';
    newdiv.setAttribute('id', divIdName);
    ni.appendChild(newdiv);

    $('#' + divIdName).load('/Profile/ajAction?i=' + num, function() {//AJAX  

    });

}

function delete_action()
{
    //data storage
   
    var d = document.getElementById('actions_zone');
    var numi = document.getElementById('theValue').value;
     
    if (numi > 0)//to avoid negative value
    {
        
        var vieuxdiv = document.getElementById('mon' + numi + 'Div');
        document.getElementById('theValue').value = document.getElementById('theValue').value - 1;

        d.removeChild(vieuxdiv);
    }

}

function actionscenario(i) {

    if (document.getElementById('bouton_' + i).style.display == 'none')
        //display 
        document.getElementById('bouton_' + i).style.display = 'block';
    else
        //hide
        document.getElementById('bouton_' + i).style.display = 'none';
}

function add_movement()
{
    //data storage
    var ni = document.getElementById('movements_zone');
    var newdiv = document.createElement('div');
    var numi = document.getElementById('theValue');
    var num = (document.getElementById('theValue').value - 1) + 2;

    numi.value = num;
    var divIdName = 'mon' + num + 'Div';

    newdiv.setAttribute('id', divIdName);
    ni.appendChild(newdiv);

    $('#' + divIdName).load('/Profile/adMovement?i=' + num, function() {//AJAX 
    });
}

function changeMoves(form) {
    //var select = form.selectCont.selectedIndex;
    var select = document.getElementById('selectCont').value;

    var obj = document.getElementById('select01Move').style;
    obj.display = 'table-cell';

    $('#select01Move').load('/Profile/adMove?control=' + select, function() {

        $('#displaybuttons').load('/Profile/adButtons', function() {//AJAX
        });//AJAX
    });


}

function changeMovesEdit(scenId) {

    var scId = scenId;

    location.href = "/Profile/adMoveEdit?scenario_id=" + scId;
}


function refreshMembers() {


    //data storage
    Name = document.getElementById("Name").value;
    Pswd1 = document.getElementById("Pswd1").value;
    Pswd2 = document.getElementById("Pswd2").value;
    checkboxAdult = document.getElementById("checkboxAdult").checked;
    

    //set css design to default
    document.getElementById("ErrorName").className = "";
    document.getElementById("ErrorPswd1").className = "";
    document.getElementById("ErrorPswd2").className = "";


    //secure
    if ((Name == '') || (Pswd1 == '') || (Pswd2 == '') || (Pswd1 != Pswd2)) {

        //name secure
        if (Name == '')
            document.getElementById("ErrorName").className = "control-group error"; //css design warning

        //password secure
        if (Pswd1 == '')
            document.getElementById("ErrorPswd1").className = "control-group error"; //css design warning

        //password (repeated) secure
        if (Pswd2 == '')
            document.getElementById("ErrorPswd2").className = "control-group error"; //css design warning

        //password and repeated password secure
        if (Pswd1 != Pswd2) {
            document.getElementById("ErrorPswd1").className = "control-group error"; //css design warning
            document.getElementById("ErrorPswd2").className = "control-group error";
        }
    } else {
        //hide
        document.getElementById('form_members').style.display = 'none';
        
        $('#tableUser').load('/Profile/ajUser?Name=' + Name + '&Pass=' + Pswd1 + '&Pass2=' + Pswd2 + '&checkboxAd=' + checkboxAdult, function() {//AJAX

        });
    }
}

function date_heure(id)
{
    date = new Date;
    annee = date.getFullYear();
    moi = date.getMonth();
    mois = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
    j = date.getDate();
    jour = date.getDay();
    jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
    h = date.getHours();
    if (h < 10)
    {
        h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10)
    {
        m = "0" + m;
    }
    s = date.getSeconds();
    if (s < 10)
    {
        s = "0" + s;
    }
    //resultat = jours[jour]+' '+j+'/'+mois[moi]+'/'+annee+' - '+h+':'+m+':'+s;
    resultat = j + '/' + mois[moi] + '/' + annee + ' - ' + h + ':' + m + ':' + s;
    document.getElementById(id).innerHTML = resultat;
    setTimeout('date_heure("' + id + '");', '1000');
    return true;
}


