// form_collections
// https://symfony.com/doc/current/form/form_collections.html

const addTagLinkDestination = document.createElement('a')
addTagLinkDestination.classList.add('add_tag_list')
addTagLinkDestination.href='#'
addTagLinkDestination.innerText='Ajouter une destination'
addTagLinkDestination.dataset.collectionHolderClass='destinations'

const newLinkLiDestination = document.createElement('li').append(addTagLinkDestination)

const collectionHolderDestination = document.querySelector('ul.destinations')
collectionHolderDestination.appendChild(addTagLinkDestination)

const addFormToCollectionDestination = (e) => {
	const collectionHolderDestination = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

      const item = document.createElement('li');

      item.innerHTML = collectionHolderDestination
        .dataset
        .prototype
        .replace(
          /__name__/g,
          collectionHolderDestination.dataset.index
        );

      collectionHolderDestination.appendChild(item);

      collectionHolderDestination.dataset.index++;
}
addTagLinkDestination.addEventListener('click', (event) => {
  event.preventDefault();
});
addTagLinkDestination.addEventListener("click", addFormToCollectionDestination)
