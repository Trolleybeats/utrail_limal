<script setup lang="ts">
const imgCubitus =
    'https://www.figma.com/api/mcp/asset/e9f6482c-00b0-473a-ae17-ae5424fdf30e';
const imgTrakks =
    'https://www.figma.com/api/mcp/asset/de3a2064-cf06-41e3-82e0-2e9304c9a534';
const imgNutribay =
    'https://www.figma.com/api/mcp/asset/48a3823f-4d2d-4d88-8bf8-526d0636923f';
const imgFacebook =
    'https://www.figma.com/api/mcp/asset/26c30f58-29c1-4508-9b33-408276a09bbd';
</script>

<template>
    <footer class="w-full bg-[#1e1e1e] text-[#f6f6f6]">
        <!-- Main footer area -->
        <div class="mx-auto w-[1182px] pt-8 pb-4">
            <!-- Facebook icon row -->
            <div class="mb-6 flex justify-end">
                <a
                    href="https://www.facebook.com"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Facebook"
                >
                    <img
                        src="storage/Facebook.png"
                        alt="Facebook"
                        class="h-[40px] w-[40px] object-contain"
                    />
                </a>
            </div>

            <!-- Nav links row 1 -->
            <nav class="mb-8">
                <ul
                    class="flex flex-row flex-wrap gap-x-25 gap-y-3 text-[20px] font-normal"
                >
                    <li>
                        <a
                            href="/presentation"
                            class="whitespace-nowrap hover:underline"
                            >Présentation</a
                        >
                    </li>
                    <li>
                        <a
                            href="/histoire"
                            class="whitespace-nowrap hover:underline"
                            >Histoire du club</a
                        >
                    </li>
                    <li>
                        <a
                            href="/equipe"
                            class="whitespace-nowrap hover:underline"
                            >L'équipe</a
                        >
                    </li>
                    <li>
                        <a
                            href="/projet"
                            class="whitespace-nowrap hover:underline"
                            >Projet de l'année</a
                        >
                    </li>
                    <li>
                        <a
                            href="/formation"
                            class="whitespace-nowrap hover:underline"
                            >Utrail formation</a
                        >
                    </li>
                    <li>
                        <a
                            href="/contact"
                            class="whitespace-nowrap hover:underline"
                            >Contact</a
                        >
                    </li>
                </ul>
            </nav>

            <!-- Nav links row 2 + sponsor logos -->
            <div class="mb-8 flex items-center justify-between">
                <a
                    href="/mentions-legales"
                    class="text-[20px] font-normal whitespace-nowrap hover:underline"
                >
                    Mentions légales
                </a>

                <!-- Sponsor logos -->
                <div class="flex items-center gap-30">
                    <img
                        src="storage/Cubitus.png"
                        alt="Cubitus"
                        class="h-[88px] w-[88px] object-contain"
                    />
                    <img
                        src="storage/Trakks.png"
                        alt="Trakks"
                        class="h-[28px] w-[88px] object-contain"
                    />
                    <img
                        src="storage/Nutribay.png"
                        alt="Nutribay"
                        class="h-[88px] w-[88px] object-contain"
                    />
                </div>

                <a
                    href="/confidentialite"
                    class="text-[20px] font-normal whitespace-nowrap hover:underline"
                >
                    Politique de confidentialité
                </a>
            </div>
        </div>

        <!-- Copyright bar -->
        <div class="w-full bg-black py-3">
            <p class="text-center text-[20px] font-normal text-white">
                © U-Trail Limal 2026
            </p>
        </div>
    </footer>
</template>
