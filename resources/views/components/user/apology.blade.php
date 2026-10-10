<style>
    .apology-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .apology-modal .modal-content {
        position: relative;
        background-color: gainsboro;
        margin: 15% auto;
        padding: 20px;
        width: 70%;
        max-width: 600px;
        border-radius: 5px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .apology-modal .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .apology-modal .close-button {
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        padding: 0 8px;
    }

    .apology-modal .modal-buttons {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }

    .apology-modal button {
        padding: 4px 8px;
        background-color: var(--main);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .apology-modal button:hover {
        background-color: grey;
    }
</style>


<div id="apology-modal" class="apology-modal rounded-lg rtl persol-farsi-font" dir="rtl">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div id="message-body" class="pb-4" style="text-align: justify; direction: rtl;">
            <h1 class="text-2xl justify-center text-center pb-4">
                🔔
            </h1>
            <p>
                به علت عدم دسترسی به اینترنت بین المللی و نداشتن جایگزین ملی برای برخی از کتابخانه های نرم افزاری،
                بسیاری از عناصر و ماژولهای این اپ به نحوه قبل خوانا، پویا و قادر به خدمات رسانی نیستند.
                😔
            </p>
            <p>
                پیشاپیش عذر خواهی ما را پذیرا باشید 🙏 به
                امید ثبات و پایداری زودهنگام
                🍀
            </p>
        </div>
        <div class="modal-buttons">
            <button onclick="closeApologyModal()" style="margin-right:10px;"> بستن</button>
        </div>
    </div>
</div>

<script>
    const today = new Date().toISOString().slice(0, 10);

    function showApologyModal() {
        const lastShownDate = localStorage.getItem('apologyLastShown');
        if (!lastShownDate || lastShownDate !== today) document.getElementById('apology-modal').style.display = 'block'
    }

    function closeApologyModal() {
        document.getElementById('apology-modal').style.display = 'none';
        localStorage.setItem('apologyLastShown', today);
    }

    showApologyModal();
</script>


