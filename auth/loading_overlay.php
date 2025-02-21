<style>
    .load-screen{
        top: 50%; /* Center vertically */
		left: 50%; /* Center horizontally */
		transform: translate(-50%, -50%);
		position: absolute; /* Places it on top */
		width: 100vw; /* Adjust size */
		height: 100vh;
		padding: 10px;
		background: rgba(25, 43, 63, 0.44); /* Translucent white */
        backdrop-filter: blur(20px) contrast(1.2) saturate(120%) brightness(0.8);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Soft shadow */
        animation: fadeIn 0.5s ease-in-out;
		z-index: 5000;
	}
	.load{
		position: absolute; /* Places it on top */
		top: 70%; /* Center vertically */
		left: 50%; /* Center horizontally */
		transform: translate(-50%, -50%); /* Perfect centering */
		width: 50; /* Adjust size */
		height: 50%;
		padding: 10px;
		filter: drop-shadow(2px 2px 2px rgba(0, 0, 0, 0.4));
	}

    /* HTML: <div class="loader"></div> */
    .loader {
        width: 65px;
        aspect-ratio: 1;
        position: relative;
    }
    .loader:before,
    .loader:after {
        content: "";
        position: absolute;
        border-radius: 50px;
        box-shadow: 0 0 0 3px inset #fff;
        animation: l4 2.5s infinite;
    }
    .loader:after {
        animation-delay: -1.25s;
    }
    @keyframes l4 {
        0% {
        inset: 0 35px 35px 0;
        }
        12.5% {
        inset: 0 35px 0 0;
        }
        25% {
        inset: 35px 35px 0 0;
        }
        37.5% {
        inset: 35px 0 0 0;
        }
        50% {
        inset: 35px 0 0 35px;
        }
        62.5% {
        inset: 0 0 0 35px;
        }
        75% {
        inset: 0 0 35px 35px;
        }
        87.5% {
        inset: 0 0 35px 0;
        }
        100% {
        inset: 0 35px 35px 0;
        }
    }
    @keyframes fadeIn {
    from {
        opacity: 0;
        backdrop-filter: blur(0px);
    }
    to {
        opacity: 1;
        backdrop-filter: blur(15px);
    }
}
</style>

<div class="load-screen" id="loading-overlay" style="display: none;">
    <div class="load">
        <div class="loader"></div>
    </div>
</div>
