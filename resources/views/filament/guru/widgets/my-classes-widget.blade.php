<x-filament-widgets::widget>

    {{-- Filter Card --}}
    <div style="background:#1f2937;border-radius:12px;padding:16px;margin-bottom:16px;">
        <select wire:model.live="filterMapel"
            style="background:#374151;border:1px solid #4b5563;border-radius:8px;padding:8px 12px;font-size:14px;color:white;width:auto;">
            <option value="">Semua Mata Pelajaran</option>
            @foreach($this->getMapelList() as $mapel)
                <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
            @endforeach
        </select>
    </div>

    {{-- Grid Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:16px;">
        @forelse($this->getKelas() as $kelas)
            @foreach($kelas->pengajaran as $p)
                <div style="background:#1f2937;border:1px solid #374151;border-radius:12px;padding:16px;">

                    {{-- Badge --}}
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                        <span style="background:#1d4ed8;color:#bfdbfe;font-size:12px;font-weight:600;padding:4px 10px;border-radius:999px;">
                            {{ $p->mapel->nama ?? '-' }}
                        </span>
                        <span style="color:#9ca3af;font-size:12px;">
                            {{ $kelas->jumlah_siswa }} Siswa
                        </span>
                    </div>

                    {{-- Icon + Nama --}}
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                        <div style="background:#1e3a5f;padding:10px;border-radius:10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#60a5fa" style="width:32px;height:32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-weight:700;color:white;margin:0;">{{ $p->mapel->nama ?? '-' }}</p>
                            <p style="font-size:12px;color:#9ca3af;margin:0;">{{ $p->mapel->jenjang->nama ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div style="border-top:1px solid #374151;padding-top:12px;display:flex;flex-direction:column;gap:8px;">
                        <div>
                            <p style="font-size:11px;color:#9ca3af;margin:0;">Kelas</p>
                            <p style="font-weight:600;color:#f3f4f6;margin:0;">{{ $kelas->nama_kelas }}</p>
                        </div>
                        <div>
                            <p style="font-size:11px;color:#9ca3af;margin:0;">Jenjang</p>
                            <p style="font-weight:600;color:#f3f4f6;margin:0;">{{ $kelas->jenjang }}</p>
                        </div>
                        <div>
                            <p style="font-size:11px;color:#9ca3af;margin:0;">Keterangan</p>
                            <p style="font-weight:600;color:#f3f4f6;margin:0;">{{ $kelas->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @empty
            <div style="text-align:center;padding:48px;color:#9ca3af;grid-column:1/-1;">
                Tidak ada kelas ditemukan.
            </div>
        @endforelse
    </div>

    {{-- Info Bar --}}
    <div style="background:#1e3a5f;border:1px solid #1d4ed8;border-radius:10px;padding:12px 16px;font-size:14px;color:#93c5fd;display:flex;align-items:center;gap:8px;">
        ℹ️ Anda hanya dapat melihat informasi. Perubahan data dilakukan oleh administrator.
    </div>

</x-filament-widgets::widget>