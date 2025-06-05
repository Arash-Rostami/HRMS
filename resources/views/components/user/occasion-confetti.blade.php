<div x-data="{isConfettiVisible: false}" x-cloak>
    <div class="confetti-container" x-show="isConfettiVisible">
        <div class="confetti"
             x-init="setTimeout(() => isConfettiVisible=true,7000)"
             x-on:animationend="isConfettiVisible=!isConfettiVisible;">
        </div>
    </div>
</div>
