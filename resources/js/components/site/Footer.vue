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
        <div class="mx-auto w-full max-w-[1182px] px-4 pt-8 pb-4">
            <!-- Facebook icon row -->
            <div class="mb-6 flex justify-end">
                <a
                    href="https://www.facebook.com/profile.php?id=61566596292504"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Facebook"
                >
                    <img
                        src="/storage/Facebook.png"
                        alt="Facebook"
                        class="h-[40px] w-[40px] object-contain"
                    />
                </a>
            </div>

            <!-- Nav links row 1 -->
            <nav aria-label="Navigation pied de page" class="mb-8">
                <ul
                    class="flex flex-row flex-wrap gap-x-9 gap-y-3 text-base font-normal md:flex-nowrap md:gap-x-16 md:text-[20px] lg:gap-x-25"
                >
                    <li>
                        <a href="/" class="whitespace-nowrap hover:underline"
                            >Accueil</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Presentation"
                            class="whitespace-nowrap hover:underline"
                            >Histoire du club</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Equipe"
                            class="whitespace-nowrap hover:underline"
                            >L'équipe</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Projet"
                            class="whitespace-nowrap hover:underline"
                            >Projet de l'année</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Formation"
                            class="whitespace-nowrap hover:underline"
                            >Utrail formation</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Contact"
                            class="whitespace-nowrap hover:underline"
                            >Contact</a
                        >
                    </li>
                </ul>
            </nav>

            <!-- Nav links row 2 + sponsor logos -->
            <div
                class="mb-8 flex flex-col items-center gap-6 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between"
            >
                <p>
                    <a
                        href="/MentionLegale"
                        class="text-base font-normal whitespace-nowrap hover:underline md:text-[20px]"
                    >
                        Mentions légales
                    </a>
                </p>

                <!-- Sponsor logos -->
                <div class="flex items-center gap-8 md:gap-16 lg:gap-30">
                    <figure>
                        <a
                            href="https://www.kine-cubitus.be/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Cubitus"
                        >
                            <img
                                src="/storage/Cubitus.png"
                                alt="Cubitus"
                                class="h-[60px] w-[60px] object-contain md:h-[88px] md:w-[88px]"
                            />
                        </a>
                    </figure>
                    <figure>
                        <a
                            href="https://www.trakks.be/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Trakks"
                        >
                            <img
                                src="/storage/Trakks.png"
                                alt="Trakks"
                                class="h-[20px] w-[60px] object-contain md:h-[28px] md:w-[88px]"
                            />
                        </a>
                    </figure>
                    <figure>
                        <a
                            href="https://www.nutri-bay.com/?gad_source=1&gad_campaignid=23160452095&gbraid=0AAAAADLj-_k5EqPqE0C4vuiRAyvL8GvNS&gclid=Cj0KCQjwv-LOBhCdARIsAM5hdKeTkcDJ5bwRUbwoJVAgM9mxowqHC7fhjeSWCXj7MfwqUc6PyoNGTXUaAsjVEALw_wcB"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Nutribay"
                        >
                            <img
                                src="/storage/Nutribay.png"
                                alt="Nutribay"
                                class="h-[60px] w-[60px] object-contain md:h-[88px] md:w-[88px]"
                            />
                        </a>
                    </figure>
                </div>

                <p>
                    <a
                        href="/Confidentialite"
                        class="text-base font-normal whitespace-nowrap hover:underline md:text-[20px]"
                    >
                        Politique de confidentialité
                    </a>
                </p>
            </div>
        </div>

        <!-- Copyright bar -->
        <div class="w-full bg-black py-3">
            <p
                class="text-center text-base font-normal text-white md:text-[20px]"
            >
                © U-Trail Limal {{ new Date().getFullYear() }}
            </p>
        </div>
    </footer>
</template>
