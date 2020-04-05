let user_info=[];

if(localStorage.Users){
	user_info=JSON.parse(localStorage.Users);
}

let form=document.getElementById("form");

form.addEventListener("submit", function(event){
	event.preventDefault();

	let inputs = document.getElementById('form').elements;
	
	let name = inputs[0].value;
	let mail = inputs[1].value;
	let tel = inputs[2].value;
	let text = inputs[3].value;
	let suhlas = inputs[4].value;
	console.log("meno je: " + name);
	//return;
	if(name==="" || mail==="" || text ==="" || !suhlas){
		Swal.fire(
			'Chyba',
			'Jedno z tvojich povinných polí nie je vyplnené',
			'error'
		)
		return;
	}

	const newUser =
		{
			name: name,
			email: mail,
			tel : tel,
			text: text,
			suhlas: suhlas,
			created: new Date()
		};


	user_info.push(newUser);

	localStorage.Users = JSON.stringify(user_info);

	Swal.fire(
		'Gratulujem',
		'Úspešne ste sa zapísali',
		'success'
	)
	console.log("New opinion added");
	console.log(user_info);


	form.reset();
});

