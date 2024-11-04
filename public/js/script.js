function toggleForm(formId) {
    console.log("Toggle form called for: " + formId); // Pour le débogage

    // Cacher tous les formulaires
    const forms = document.querySelectorAll('.hidden');
    forms.forEach(form => {
        form.classList.add('hidden');
    });

    // Afficher le formulaire sélectionné
    const selectedForm = document.getElementById(formId);
    selectedForm.classList.toggle('hidden');
}
