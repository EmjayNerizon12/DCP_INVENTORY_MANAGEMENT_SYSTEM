<script>
    const btnDiv1 = document.getElementById('btnDiv1');
    const btnDiv2 = document.getElementById('btnDiv2');
    const divContainer1 = document.getElementById('divContainer1');
    const divContainer2 = document.getElementById('divContainer2');
    const viewSelector = document.querySelector('[data-switch-selector]');

    function toggleUserView(view) {
        const showCards = String(view) !== '1';

        divContainer1.classList.toggle('hidden', !showCards);
        divContainer2.classList.toggle('hidden', showCards);

        if (viewSelector) {
            viewSelector.value = showCards ? '0' : '1';
        }

        if (btnDiv1 && btnDiv2) {
            if (showCards) {
                btnDiv1.classList.remove('btn-cancel');
                btnDiv1.classList.add('btn-submit');

                btnDiv2.classList.remove('btn-submit');
                btnDiv2.classList.add('btn-cancel');
            } else {
                btnDiv2.classList.remove('btn-cancel');
                btnDiv2.classList.add('btn-submit');

                btnDiv1.classList.remove('btn-submit');
                btnDiv1.classList.add('btn-cancel');
            }
        }
    }

    function showDiv1() {
        toggleUserView('0');
    }

    function showDiv2() {
        toggleUserView('1');
    }
    showDiv1();
</script>
