$(document).ready();
searchItems = $('.vendor-search-product');
console.log(searchItems);
result = $('.products');
searchBar = document.getElementById("vendor-search");
let searchText = [];
for(let i=0; i<searchItems.length; i++){
    searchText[i] = searchItems[i].innerHTML;
}

searchBar.addEventListener('keyup', (e) => {
    const searchString = e.target.value.toLowerCase();
    const filteredItems = searchText.filter(item =>{
        return item.toLowerCase().includes(searchString);
    });
    for(let i=0; i<searchItems.length; i++){
        let a =searchItems[i].text;
        if( a.toLowerCase().includes(searchString)){
            searchItems[i].classList.remove('is-hidden');
        }else{
            searchItems[i].classList.add('is-hidden');
        }
    }
});