// form_collections
// https://symfony.com/doc/current/form/form_collections.html

// const app = {
//   init: function() {
//     document
//       .querySelectorAll('.add_item_link')
//       .forEach(btn => {
//           btn.addEventListener("click", app.addFormToCollection)
//       });
//   },

//   addFormToCollection: function(e) {
//     const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
  
//     const item = document.createElement('li');
  
//     item.innerHTML = collectionHolder
//       .dataset
//       .prototype
//       .replace(
//         /__name__/g,
//         collectionHolder.dataset.index
//       );
  
//     collectionHolder.appendChild(item);
  
//     collectionHolder.dataset.index++;
//   }
// }

const addTagLink = document.createElement('a')
addTagLink.classList.add('add_tag_list')
addTagLink.href='#'
addTagLink.innerText='Ajouter un voyageur'
addTagLink.dataset.collectionHolderClass='travelers'

const newLinkLi = document.createElement('li').append(addTagLink)

const collectionHolder = document.querySelector('ul.travelers')
collectionHolder.appendChild(addTagLink)

const addFormToCollection = (e) => {
	const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

      const item = document.createElement('li');

      item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
          /__name__/g,
          collectionHolder.dataset.index
        );

      collectionHolder.appendChild(item);

      collectionHolder.dataset.index++;
}

addTagLink.addEventListener("click", addFormToCollection)