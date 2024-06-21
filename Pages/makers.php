<?php include "../headerNfooter/header.php";?>

<div class="carousel-wrapper">
    <div class="carousel-container">
        <template id="carousel-template">
            <div class="carousel-item">
                <img src="" alt="Person's Image" class="carousel-image">
                <p class="carousel-name">Name</p>
                <p class="carousel-info">Info</p>
            </div>
        </template>

        <div id="carousel-content" class="carousel-content"></div>

        <div class="carousel-nav">
            <button id="prev">← Prev</button>
            <button id="next">Next →</button>
        </div>
    </div>
</div>


    <script>
   document.addEventListener('DOMContentLoaded', function() {
    const people = [
        {
            image: '../img/MakerMalik.jpg',
            name: 'Malik Omri',
            info: '17 years old <br> Software Developer <br> #1 Maker van Website'
        },
        {
            image: '../img/MakerGiovanni.jpg',
            name: 'Giovanni Krapels',
            info: '17 years old <br> Software Developer <br> #2 Maker van Website'
        }
    ];

    const template = document.getElementById('carousel-template').content;
    const carouselContent = document.getElementById('carousel-content');
    let currentIndex = 0;

    function showPerson(index) {
        // Remove active class from all items
        const activeItems = document.querySelectorAll('.carousel-item.active');
        activeItems.forEach(item => {
            item.classList.remove('active');
        });

        // Create a new slide for the current person
        const person = people[index];
        const clone = document.importNode(template, true);
        clone.querySelector('.carousel-image').src = person.image;
        clone.querySelector('.carousel-name').textContent = person.name;
        clone.querySelector('.carousel-info').innerHTML = person.info;

        // Add active class to show the new slide
        clone.querySelector('.carousel-item').classList.add('active');
        carouselContent.appendChild(clone);
    }

    // Event listeners for navigation buttons
    document.getElementById('prev').addEventListener('click', function() {
        currentIndex = (currentIndex === 0) ? people.length - 1 : currentIndex - 1;
        showPerson(currentIndex);
    });

    document.getElementById('next').addEventListener('click', function() {
        currentIndex = (currentIndex === people.length - 1) ? 0 : currentIndex + 1;
        showPerson(currentIndex);
    });

    // Show initial person
    showPerson(currentIndex);
});

</script>

<?php include "../headerNfooter/footer.php";?>