/*
 *
 * In this file app.js you will find all CRUD functions name.
 *
 */

let form = document.getElementById("form");
let title = document.getElementById("taskTitle");
let feature = document.getElementById("feature");
let bug = document.getElementById("bug");
let priority = document.getElementById("priority");
let taskStatus = document.getElementById("status");
let date = document.getElementById("date");
let description = document.getElementById("description");
let toDo = document.getElementById("to-do-tasks");
let inProgress = document.getElementById("in-progress-tasks");
let done = document.getElementById("done-tasks");
let add = document.getElementById("save-button");

// add event listener to add task
document.getElementById("add-button").addEventListener ("click", createTask);

// disable save button on empty title
let enableADD = () => {
  if (title.value === "") {
    add.disabled=true;
    document.getElementById("update-button").disabled=true;}
    else{
  add.disabled = false;
  document.getElementById("update-button").disabled=false;
  }
};

function createTask() {
  // initialiser task form
  initTaskForm();
  // Afficher le boutton save
  add.classList.remove("d-none");
  document.getElementById("cancel-button").classList.remove("d-none");
  // Ouvrir modal form
  $("#form").modal("show");
}

function editTask(index) {
  // Initialisez task form
  initTaskForm();
  document.getElementById("update-button").disabled=false;
  // Affichez updates
  document.getElementById("update-button").classList.remove("d-none");
  // Delete Button
  document.getElementById("delete-button").classList.remove("d-none");
  // Définir l’index en entrée cachée pour l’utiliser en Update et Delete
  // Definir FORM INPUTS
  let indexQuery;
  indexQuery = document.getElementById(index);
  // Definir l'index en entrée cachée
  document.getElementById("task-id").value = index;
  // Definir title
  title.value = indexQuery.children[1].children[2].children[1].innerText;
  // Definir type
  if (indexQuery.children[1].children[2].children[1].innerText =="Feature") {feature.checked=true} else {bug.checked=true}
  // Definir priority
  if (indexQuery.children[1].children[2].children[0].innerText =="Low")
  {priority.value=1} else if (indexQuery.children[1].children[2].children[0].innerText =="Medium") {priority.value=2} else if (indexQuery.children[1].children[2].children[0].innerText =="High") {priority.value=3} else {priority.value=4}
  // Definir status
  if (indexQuery.parentElement.id == "to-do-tasks") {
      taskStatus.value = 1;
    } else if (indexQuery.parentElement.id == "in-progress-tasks") {
      taskStatus.value = 2;
    } else if (indexQuery.parentElement.id == "done-tasks") {
      taskStatus.value = 3;
    }
  // Definir date
  date.value = indexQuery.children[1].children[1].children[0].innerText.slice(-10);
  // Definir description
  description.value = indexQuery.children[1].children[1].children[1].innerText;
  // Ouvrir Modal form
  $("#form").modal("show");
}

function initTaskForm() {
  // Clear task form from data
  form.reset();
  // Hide all action buttons

  add.classList.add("d-none");
  document.getElementById("cancel-button").classList.add("d-none");
  document.getElementById("delete-button").classList.add("d-none");
  document.getElementById("update-button").classList.add("d-none");

  enableADD();
}

let dragId;

function drag(dragEvent) {
  dragId = (dragEvent.target.id.slice(4)) - 1;
}

function allowDrop(dragEvent) {
  dragEvent.preventDefault();
}

function dropToDo(dragEvent){
  dragEvent.preventDefault();
  tasks[dragId].status = "To Do";
  reloadTasks();
}

function dropInProgress(dragEvent){
  dragEvent.preventDefault();
  tasks[dragId].status = "In Progress";
  reloadTasks();
}

function dropDone(dragEvent){
  dragEvent.preventDefault();
  tasks[dragId].status = "Done";
  reloadTasks();
}

