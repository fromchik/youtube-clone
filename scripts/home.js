function selectCategory(element){
    const buttons = document.querySelectorAll('.category-bar__button');
    buttons.forEach(button => {
        button.classList.remove('category-bar__button--selected');
    });
    element.classList.add('category-bar__button--selected');
}

