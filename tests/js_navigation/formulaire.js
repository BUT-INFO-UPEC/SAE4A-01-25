document.addEventListener("DOMContentLoaded", () => {
  const titlesContainer = document.getElementById("titles");
  const formContainer = document.getElementById("form-container");
  const addPartButton = document.getElementById("add-part");

  let formParts = [];
  let currentIndex = 0;

  // Fonction pour mettre à jour la liste des titres
  const updateTitles = () => {
    titlesContainer.innerHTML = "";
    titlesContainer.appendChild(addPartButton); // Remettre le bouton "+"

    formParts.forEach((part, index) => {
      const button = document.createElement("button");
      button.textContent = part.title || `Partie ${index + 1}`;
      button.addEventListener("click", () => switchToPart(index));
      titlesContainer.appendChild(button);
    });
  };

  // Fonction pour afficher une partie
  const switchToPart = (index) => {
    document.querySelectorAll(".form-part").forEach((part, idx) => {
      part.classList.toggle("active", idx === index);
    });
    currentIndex = index;
  };

  // Fonction pour ajouter une nouvelle partie
  const addPart = () => {
    const newIndex = formParts.length;
    const newPart = {
      title: `Partie ${newIndex + 1}`,
      content: `Contenu de la partie ${newIndex + 1}`,
    };
    formParts.push(newPart);

    // Créer un nouvel élément de formulaire
    const formPart = document.createElement("div");
    formPart.className = "form-part";
    if (newIndex === 0) formPart.classList.add("active"); // Activer la première partie

    // Ajouter le contenu dynamique
    formPart.innerHTML = `
      <h3>${newPart.title}</h3>
      <p>${newPart.content}</p>
      <label>Nom :</label>
      <input type="text" placeholder="Nom de cette partie" onchange="updateTitle(${newIndex}, this.value)" />
      <br>
			<label>Titre :</label>
			<input 
				type="text" 
				placeholder="Titre de cette partie" 
				onchange="updatePartTitle(${newIndex}, this.value)" 
			/>
			<br>
      <button class="delete-part" onclick="deletePart(${newIndex})">Supprimer cette partie</button>
    `;

    formContainer.appendChild(formPart);
    updateTitles();
  };

  // Fonction pour supprimer une partie
  const deletePart = (index) => {
    // Supprimer la partie du tableau
    formParts.splice(index, 1);

    // Supprimer la partie HTML
    const parts = document.querySelectorAll(".form-part");
    parts[index].remove();

    // Réinitialiser les indices dans formParts et dans le DOM
    formParts = formParts.map((part, i) => {
      part.title = `Partie ${i + 1}`; // Renommer les titres après suppression
      return part;
    });

    // Mettre à jour les titres et l'affichage
    updateTitles();
    switchToPart(Math.max(0, index - 1)); // Afficher la partie précédente si possible
  };

	const updatePartTitle = (index, newTitle) => {
		if (!newTitle) return; // Ne rien faire si le champ est vide
	
		// Mettre à jour le titre dans le tableau
		formParts[index].title = newTitle;
	
		// Mettre à jour l'affichage dans la liste des boutons
		updateTitles();
	};

  // Ajouter la gestion de clic pour ajouter une partie
  addPartButton.addEventListener("click", addPart);

  // Ajouter la première partie par défaut
  addPart();

  // Rendre `deletePart` accessible globalement pour le bouton
  window.deletePart = deletePart;
  window.updatePartTitle = updatePartTitle;
});
