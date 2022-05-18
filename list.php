
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/cffcdc6888.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="css/team.css" />
  <title>Team Generator</title>
  <style>
    .Navbar{
      display: flexbox;
      justify-content: center;
      background-color:#0E4DA4;
      justify-self: start;
      width: 100%;
      height: 5rem;
      align-items: center;
  }
  
  #h1{
    position: absolute;
    left: 3rem;
    top:1rem;
    font-family: Inter;
    justify-content: center;
    font-size: 20px;
    color: whitesmoke;
  }
  .Navbar-container{
      margin-left: 95%;
      margin-top: -25px;
      padding-bottom: 15px;
  }
  .buttoninfo{
      transition: 0.5s;
      top:1em;
      left:37em;
      position: absolute;
  }
  .buttoninfo:hover{
      background-color: #0E4DA4;
  }
  .error {
  transition: ease-in-out 1s transform;
  padding: 1rem 10rem;
  border-radius: 10rem;
  font-weight: bold;
  position: absolute;
  top: -4rem;
  left: calc(15% - 5rem);
  color: white;
  background-color: red;
}
  </style>
</head>

<body>
  <div class='Navbar'>
    <a href="index.html"><h1 id="h1">Team Generator</h1></a>
    <div class='Navbar-Container'>
    <a href="info.html" class="buttoninfo"><i class="fa-solid fa-circle-info"></i></a>
    </div>
  </div>
  <header>
    <h1><strong></strong></h1>
  </header>

  <!-- /* ===================== INPUT ======================= */ -->
  <main>
    <section class="input">
      <h3>Insert Name</h3>
      <form action="">
        <label for="name">Member name</label>
        <input type="name" id="name" name = "name" class="name" required>
        <div class="error" id ='error'></div>
        <input type="submit" class="add" value="+"> 
        </div>
      </form>
      <form>
        <div class="error" id ='error'></div>
        <label class="change" for="size">Team size</label>
        <input type="number" id="size"/> 
        <button class="retreive">Retreive</button>
      </form>
    </section>
    <!-- /* ================== CONTROLLER ===================== */ -->
    <section class="controller">
      <h3>Controller</h3>
      <form action="">
        <label>Distribution:</label>
        <select name="distribution" id="distribution">
          <option value="noalone">Team size</option>
          <option value="teamnum">Nº Teams</option>
        </select>
        <br />
        <label>Team Name:</label>

        <select name="teams-name" id="teams-name">
          <option value="number">Number</option>
          <option value="element">Elements</option>
          <option value="animal">Animals</option>
        </select>
      </form>
      <p class="inf-teams">Teams: 0</p>
      <p class="inf-memb"> Memb.: 0</p>
      <a class="start">Start</a>
      <a class="clear">Clear</a>
      <a class="save">Save</a>
    </section>
    <!-- /* ====================== LIST ======================= */ -->
    <section class="member-list">
      <h3>Member List</h3>
      <article class="list"> </article>
    </section>
    <!-- /* ===================== TEAMS ======================= */ -->
    <section class="teams">
      <h3>Generated Teams</h3>
      <h5>Click to drag members between teams</h5>
      <div class="teams-wraper"></div>
    </section>
  </main>
  <div class="saved">Saved!</div>
  <div class="teamessage">The List all is cleared there is no data to process</div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="js/teamNames.js"></script>
  <script >
    let body = document.querySelector('body');
const retrieve = document.querySelector('.retreive');

let addButton = document.querySelector('.add');
let teamSize = document.querySelector('#size');
let nameInput = document.querySelector('#name');
let teamLabel = document.querySelector('.change');

let distribution = document.querySelector('#distribution');
let members = document.querySelector('.inf-memb');
let infTeams = document.querySelector('.inf-teams');
const start = document.querySelector('.start');
const clear = document.querySelector('.clear');
const save = document.querySelector('.save');
let saveMsg = document.querySelector('.saved');
let errormsg = document.querySelector('.error');
let teamsg = document.querySelector('.teamessage')

let memberList = document.querySelector('.list');
let team = document.querySelector('.teams-wraper');

let membersNames = [];
let teamDivs = [];
let savedTeams;
let teamNumb;
let exports = [];

let edited;
let editing = false;
let originalName;
var numbers = /^[a-zA-Z]+$/;


getLocalStorage();

if (distribution.value == 'teamnum') {
  teamLabel.innerText = 'Number of teams';
} else {
  teamLabel.innerText = 'Team size';
}

addButton.addEventListener('click', addMember);
memberList.addEventListener('dblclick', editMemb);
memberList.addEventListener('click', removeMemb);
teamSize.addEventListener('input', addMockTeam);

start.addEventListener('click', generateTeams);
clear.addEventListener('click', clearAll);
save.addEventListener('click', saveToStorage);
retrieve.addEventListener('click', getLocalStorage);

distribution.addEventListener('change', newLabel);

function getLocalStorage() {
  let m = localStorage.getItem('members');

  if (m != null && m != ' ') {
    let t = localStorage.getItem('teams');
    let nT = localStorage.getItem('numbTeams');
    let nM = localStorage.getItem('numbMembers');
    membersNames = localStorage.getItem('membersNames').split(',');
    

    memberList.innerHTML = m;
    teamNumb = nT;
    membersNames[0].trim() ? membersNames : (membersNames = []);
    t == '' ? addMockTeam() : (team.innerHTML = t);
    infoUpdate(nT, nM);

  }
}
function isValidName(myval) {
    var validCharactersRegex = /^[a-z\u00C0-\u02AB'´`]+\.?\s([a-z\u00C0-\u02AB'´`]+\.?\s?)+$/;
 
    return validCharactersRegex.test(myval.trim());
}

function addMember(e) {
  e.preventDefault();
  if (nameInput.value === "") {
    alert("please enter valid name");
  } 
  if(!nameInput.value.match(numbers)  ){
    alert("please enter characters only");
  }
  else{
    if (nameInput.value.trim() != '') {
      memberList.innerHTML = '';
      membersNames.push(nameInput.value);

      for (let member of membersNames) {
        memberList.innerHTML += `<div class="member">
        <img src="img/minus.png" alt="delete" /> <input value="${member}" readonly> </div>`;
      }

      nameInput.value = '';
      addMockTeam();
    }
  }
}

function editMemb(e) {
  if (e.target.tagName == 'INPUT') {
    removeEdit();
    editing = true;
    originalName = e.target.value;
    edited = e.target;
    edited.style.backgroundColor = 'white';
    edited.style.color = 'black';
    edited.readOnly = false;
    edited.addEventListener('keydown', (e) => {
      if (e.key == 'Enter') {
        // getValue()
        removeEdit();
      }
    });
  }
}

function removeMemb(e) {
  let input = e.target.nextElementSibling;

  if (e.target.tagName == 'IMG') {
    e.target.parentElement.remove();
    for (let i = 0; i < membersNames.length; i++) {
      if (membersNames[i].trim() == input.value.trim()) {
        membersNames.splice(i, 1);
        break;
      }
    }
    addMockTeam(); //calls mock team deleting created teams
  }
}

function addMockTeam() {
  // Check for selected distribution
  teamDivs = [];
  let teamNum;
  if (distribution.value == 'teamnum') {
    teamNum = teamDistribution();
  } else {
    teamNum = noaloneDistribution();
  }

  for (let i = 0; i < teamNum; i++) {
    teamDivs.push(`<article class="team team-mock"> 
    <h4><p class="tick1">?</p><p class="tick2">?</p><p class="tick3">?</p></h4>
    <div class="team-member-list">
    <p class="tick1">?</p><p class="tick2">?</p><p class="tick3">?</p>
    </div></article>`);
  }
  team.innerHTML = teamDivs.join('');

  infoUpdate(teamNum);
}

function noaloneDistribution() {
  let size = 2;
  let extraMemb = membersNames.length % size;

  teamSize.value > 2 ? (size = teamSize.value) : '';

  let teamNum = Math.ceil(membersNames.length / size);

  if ((extraMemb != 1 || extraMemb <= teamNum - 1) && extraMemb != 0) {
    teamNum--;
  }
  return teamNum;
}

function teamDistribution() {
  let size = 1;
  if (membersNames.length > 1) {
    let max = Math.floor(membersNames.length / 2);

    teamSize.value < 1
      ? ''
      : teamSize.value > max
        ? (size = max)
        : (size = teamSize.value);
  }

  return size;
}

function newLabel() {
  if (distribution.value == 'teamnum') {
    teamLabel.innerText = 'Number of teams';
  } else {
    teamLabel.innerText = 'Team size';
  }
  teamLabel.classList.add('notify');
  setTimeout(() => {
    teamLabel.classList.remove('notify');
  }, 1000);
}

function generateTeams() {
  let teamRand;
  team.innerHTML = '';
  let teamNames = pickTeamArray();
  teamDivs.length > 0 ? (teamNumb = teamDivs.length) : '';

  if (teamNames) {
    teamRand = randomArr(teamNumb, teamNames.length);
  }
  let random = randomArr(membersNames.length, membersNames.length);
  

  for (let a = 0; a < membersNames.length; a++) {
    if (Math.floor(a / teamNumb) == 0) {
      team.innerHTML += `<article class="team" 
      style="border: 2px solid #${829891 + random[a] * (a + 10)};">
      <h4 style="background-color: #${829891 + random[a] * (a + 10)};">
      ${teamNames ? teamNames[teamRand[a]] : 'Team ' + (a + 1)}</h4>
      <div class="team-member-list">
      <p class="team-member">${membersNames[random[a]]}</p></div></article>`;
    } else {
      let teamMemberList = document.querySelectorAll('.team-member-list');
      teamMemberList[a % teamNumb].innerHTML += `<p class="team-member"> 
                                                ${membersNames[random[a]]}</p>`;
    }
    savedTeams;

  }

  let teamMember = document.querySelectorAll('.team-member');
  initializeDrag(teamMember);
  

}

function clearAll() {
  membersNames = [];
  team.innerHTML = '';
  memberList.innerHTML = '';
  alert('Data has been cleared');
}

function saveToStorage() {
  saveMsg.classList.add('show');
  setTimeout(() => {
    saveMsg.classList.remove('show');
  }, 1200);

  let savedMembers = ' ';
  for (let member of membersNames) {
    savedMembers += `<div class="member">
      <img src="img/minus.png" alt="delete" /> <input value="${member}" readonly> </div>`;
  }

  localStorage.setItem('teams', savedTeams ? savedTeams : '');
  localStorage.setItem('members', savedMembers);
  localStorage.setItem('numbTeams', teamDivs.length); //
  localStorage.setItem('numbMembers', membersNames.length);
  localStorage.setItem('membersNames', membersNames);
  console.log(membersNames);
  $.ajax({
    url: "ajaxfile.php",
    method:"post",
    data:{name:JSON.stringify(membersNames)},
    success: function(res){
      console.log(res);
    }
  });
  alert('Data has been saved to database');
}


function removeEdit() {
  if (editing) {
    edited.style.backgroundColor = 'rgb(179, 168, 143)';
    edited.style.color = 'white';
    edited.readOnly = true;
    editing = false;
    if (edited.value.trim() != '') {
      changeNames(originalName, edited.value);
    } else {
      edited.value = originalName;
    }
  }
}

function changeNames(prev, next) {
  for (let i = 0; i < membersNames.length; i++) {
    if (membersNames[i].trim() == prev.trim()) {
      membersNames[i] = next;
      break;
    }
  }
  addMockTeam();
}

function infoUpdate(teamNum, membNum = membersNames.length) {
  members.innerText = `Memb.: ${membNum}`;
  infTeams.innerHTML = `Teams: ${teamNum}`;
}

function randomArr(arrLength, arrMax) {
  let random = [];
  while (random.length < arrLength) {
    let number = Math.floor(Math.random() * arrMax);
    if (!random.includes(number)) {
      random.push(number);
    }
  }
  return random;
}

function pickTeamArray() {
  let namesArr = document.querySelector('#teams-name');
  let finalArr = [];
  if (namesArr.value == 'element') {
    finalArr = elements;
  } else if (namesArr.value == 'animal') {
    finalArr = animals;
  } else {
    finalArr = null;
  }
  return finalArr;
}

let drag = false;
let selected;
let selY;
let selX;

function initializeDrag(teamMember) {
  for (let i = 0; i < teamMember.length; i++) {
    teamMember[i].addEventListener('mousedown', move);
    teamMember[i].addEventListener('mouseup', remove);
  }
}

document.addEventListener('mouseup', removeDoc);

function move(e) {
  if (e.target.classList.contains('team-member')) {
    drag = true;
    selected = e.target;
    selY = e.clientY - 30;
    selX = e.clientX;
    body.classList.add('unselectable');
    document.addEventListener('mousemove', mousemove, true);
  }
}

function mousemove(e) {
  let axisX = e.clientX - selX;
  let axisY = e.clientY - selY;
  selected.style.transform = `translateY(${axisY}px) translateX(${axisX}px)`;
  selected.style.border = 'solid 0.5px #000';
  selected.style.position = 'sticky';
}

function remove(e) {
  if (e.target.classList.contains('team-member')) {
    let draged = selected.innerHTML;
    selected.innerHTML = e.target.innerHTML;
    e.target.innerHTML = draged;

    removeDoc();
  }
}

function removeDoc() {
  document.removeEventListener('mousemove', mousemove, true);
  removeEdit(); //couldn't get "onblur" to work
  //avoid console error
  if (selected) {
    selected.style.transform = `translateY(0px) translateX(-0.5px)`;
    selected.style.border = 'none';
    selected.style.position = 'inherit';
    selected = '';
  }

  body.classList.remove('unselectable');
  drag = false;
}

  </script>
</body>

</html>