<style>
    .trailer-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
        z-index: 100000;
    }

    .trailer-modal-content {
        background: #f0f4f8;
        padding: 25px;
        border-radius: 12px;
        max-width: 550px;
        text-align: center;
        position: relative;
        box-shadow: 0 0 15px rgba(173, 216, 230, 0.5);
    }

    .trailer-close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
        font-size: 24px;
        color: #333;
    }

    .trailer-close-btn:hover {
        color: #1e90ff;
    }

    .trailer-heading {
        font-size: 24px;
        font-weight: bold;
        color: #4682b4;
    }

    .trailer-text {
        font-size: 18px;
        margin: 15px 0;
        color: #555;
    }

    .trailer-video {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(173, 216, 230, 0.7);
    }

    .trailer-button {
        background: #4682b4;
        color: white;
        border: none;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 8px;
        margin-top: 15px;
        transition: background-color 0.3s ease;
        letter-spacing: 2px;

    }

    .trailer-button:hover {
        background: dodgerblue;
    }

    .trailer-button:focus {
        outline: none;
    }

    .trailer-button:active {
        background: deepskyblue;
    }
</style>

<div id="trailerModal" class="trailer-modal">
    <div class="trailer-modal-content">
        <span class="trailer-close-btn" title="Remind me a day later!" onclick="closeModal()">&times;</span>
        <h2 class="trailer-heading">🎭 Join Us for an Amazing Play This Saturday! 🎭</h2>
        <p class="trailer-text">✨ Get ready for a show that wows you. Don't miss out! ✨</p>
        <div>
            <video id="trailer" class="trailer-video" controls>
                <source src="video/TardigradesTrailer.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <button class="trailer-button" onclick="alert('Enjoy the show!')">🎉 TARDIGRADES SHOW 🎬</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let lastClosed = localStorage.getItem("trailerModalClosedDate");
        let today = new Date().toDateString();

        if (lastClosed !== today) {
            setTimeout(() => {
                document.getElementById("trailerModal").style.display = "flex";
            }, 1000);
        }
    });

    function closeModal() {
        document.getElementById("trailerModal").style.display = "none";
        localStorage.setItem("trailerModalClosedDate", new Date().toDateString());
    }
</script>
