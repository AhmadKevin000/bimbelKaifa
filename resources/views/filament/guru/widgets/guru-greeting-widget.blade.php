<x-filament-widgets::widget>
<style>
.gg-card {
    background: linear-gradient(135deg, #10b981 0%, #059669 50%, #0d9488 100%);
    border-radius: 0.875rem;
    padding: 1rem 1.25rem;
    color: #fff;
    box-shadow: 0 4px 15px -3px rgba(16,185,129,.3);
}
.gg-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.gg-left {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    flex: 1;
    min-width: 0;
}
.gg-avatar {
    width: 2.5rem; height: 2.5rem;
    border-radius: 50%;
    background: rgba(255,255,255,.22);
    border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.05rem; font-weight: 700;
    flex-shrink: 0;
}
.gg-sub   { font-size: .75rem; color: rgba(255,255,255,.8); margin: 0; }
.gg-name  { font-size: 1.1rem; font-weight: 700; margin: 0; line-height: 1.3;
             white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.gg-badge { display: inline-block; margin-top: 3px;
            padding: 1px 8px; border-radius: 999px;
            font-size: .65rem; font-weight: 600;
            background: rgba(255,255,255,.2); }
.gg-right { text-align: right; flex-shrink: 0; }
.gg-right-row { font-size: .75rem; color: rgba(255,255,255,.85);
                white-space: nowrap; margin-bottom: 2px; }
</style>

<div class="gg-card">
    <div class="gg-inner">
        <div class="gg-left">
            <div class="gg-avatar">{{ mb_strtoupper(mb_substr($namaGuru, 0, 1)) }}</div>
            <div style="min-width:0">
                <p class="gg-sub">{{ $greeting }},</p>
                <h2 class="gg-name">{{ $namaGuru }}</h2>
                <span class="gg-badge" style="display:inline-flex; align-items:center; gap:0.25rem;">
                    <x-heroicon-m-star style="width: 0.8rem; height: 0.8rem; color: #fde047; flex-shrink: 0;" />
                    <span>Guru {{ ucfirst($statusGuru) }}</span>
                </span>
            </div>
        </div>
        <div class="gg-right">
            <div class="gg-right-row" style="display:flex; align-items:center; justify-content:flex-end; gap:0.25rem;">
                <x-heroicon-m-calendar style="width: 0.9rem; height: 0.9rem; flex-shrink: 0;" />
                <span>{{ $tanggal }}</span>
            </div>
            <div class="gg-right-row" style="display:flex; align-items:center; justify-content:flex-end; gap:0.25rem;">
                <x-heroicon-m-clock style="width: 0.9rem; height: 0.9rem; flex-shrink: 0;" />
                <span id="gg-time-text">{{ now()->format('H:i') }} WIB</span>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    function tick(){
        var el=document.getElementById('gg-time-text');
        if(!el)return;
        var n=new Date();
        el.textContent=String(n.getHours()).padStart(2,'0')+':'+String(n.getMinutes()).padStart(2,'0')+' WIB';
    }
    setInterval(tick,30000);
})();
</script>
</x-filament-widgets::widget>
