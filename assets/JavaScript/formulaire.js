class FormManager {
	constructor({ titlesContainer, formContainer, addButton }) {
		this.titlesContainer = titlesContainer;
		this.formContainer = formContainer;
		this.addButton = addButton;
		this.formParts = [];
		this.currentIndex = 0;

		// Initialiser
		this.addButton.addEventListener("click", () => this.addPart());
		this.addPart(); // Ajouter une première partie par défaut
	}

	updateTitles() {
		this.titlesContainer.innerHTML = "";
		this.titlesContainer.appendChild(this.addButton); // Ajouter le bouton "+"

		this.formParts.forEach((part, index) => {
			const button = document.createElement("button");
			button.textContent = part.title || `Partie ${index + 1}`;
			button.addEventListener("click", () => this.switchToPart(index));
			this.titlesContainer.appendChild(button);
		});
	}

	switchToPart(index) {
		this.formContainer
			.querySelectorAll(".form-part")
			.forEach((part, idx) => {
				part.classList.toggle("active", idx === index);
			});
		this.currentIndex = index;
	}

	addPart() {
		const newIndex = this.formParts.length;
		const newPart = {
			title: `Partie ${newIndex + 1}`,
			content: `Contenu de la partie ${newIndex + 1}`,
		};
		this.formParts.push(newPart);

		const formPart = document.createElement("div");
		formPart.className = "form-part";
		if (newIndex === 0) formPart.classList.add("active");

		formPart.innerHTML = `
      <h3>${newPart.title}</h3>
      <p>${newPart.content}</p>
      <label>Titre :</label>
      <input 
        type="text" 
        placeholder="Titre de cette partie" 
        onchange="this.updateTitle(${newIndex}, this.value)" 
      />
      <button class="delete-part">Supprimer</button>
    `;

		// Gestion suppression
		formPart
			.querySelector(".delete-part")
			.addEventListener("click", () => this.deletePart(newIndex));
		this.formContainer.appendChild(formPart);

		this.updateTitles();
	}

	updateTitle(index, newTitle) {
		if (!newTitle) return;
		this.formParts[index].title = newTitle;
		this.updateTitles();
	}

	deletePart(index) {
		// Supprimer du tableau
		this.formParts.splice(index, 1);

		// Supprimer du DOM
		this.formContainer.querySelectorAll(".form-part")[index].remove();

		// Renommer les parties restantes
		this.formParts = this.formParts.map((part, i) => ({
			...part,
			title: `Partie ${i + 1}`,
		}));

		this.updateTitles();
		this.switchToPart(Math.max(0, index - 1)); // Aller à la partie précédente
	}
}

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
	const manager = new FormManager({
		titlesContainer: document.getElementById("titles"),
		formContainer: document.getElementById("form-container"),
		addButton: document.getElementById("add-part"),
	});
});
