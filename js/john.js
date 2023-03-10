console.log("HERE I AM");

nediswrong.innerHTML = "<b>Yes he knows some stuff but not all stuff!</b>";

mybutton.onclick = function click(event) { alert("I was clicked!"); };

//HARD CREATION OF A JAVASCRIPT OBJECT
person = {
    firstName: "John",
    lastName : "Doe",
    id       : 5566,

    fullName : function() {
      return this.firstName + " " + this.lastName;
    }
};
console.log(person.id);
console.log(person.fullName());
