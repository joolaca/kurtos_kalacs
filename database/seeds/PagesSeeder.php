<?php

use App\Model\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lorem =[
            'A Lorem Ipsum egy egyszerû szövegrészlete, szövegutánzata a betûszedõ és nyomdaiparnak. A Lorem Ipsum az 1500-as évek óta standard szövegrészletként szolgált az iparban; mikor egy ismeretlen nyomdász összeállította a betûkészletét és egy példa-könyvet vagy szöveget nyomott papírra, ezt használta. Nem csak 5 évszázadot élt túl, de az elektronikus betûkészleteknél is változatlanul megmaradt. Az 1960-as években népszerûsítették a Lorem Ipsum részleteket magukbafoglaló Letraset lapokkal, és legutóbb softwarekkel mint például az Aldus Pagemaker',
            'Ez egy régóta elfogadott tény, miszerint egy olvasót zavarja az olvasható szöveg miközben a szöveg elrendezését nézi. A Lorem Ipsum használatának lényege, hogy többé-kevésbé rendezettebb betûket tartalmaz, ellentétben a Tartalom helye, Tartalom helye-féle megoldással. Sok desktop szerkesztõ és weboldal szerkesztõ használja a Lorem Ipsum-ot mint alapbeállítású szövegmodellt, és egy keresés a lorem ipsum-ra sok félkész weboldalt fog eredményezni.',
            'A Lorem Ipsum részleteinek sok változata elérhetõ, de a legtöbbet megváltoztatták egy kis humorral és véletlenszerûen kiválasztott szavakkal, amik kicsit sem teszik értelmessé. Ha használni készülsz a Lorem Ipsumot, biztosnak kell lenned abban, hogy semmi kínos sincs elrejtve a szöveg közepén. Az összes internetes Lorem Ipsum készítõ igyekszik elõre beállított részleteket ismételni a szükséges mennyiségben, ezzel téve az internet egyetlen igazi Lorem Ipsum generátorává ezt az oldalt. Az oldal körülbelül 200 latin szót használ, egy maroknyi modell-mondatszerkezettel így téve a Lorem Ipsumot elfogadhatóvá. Továbbá az elkészült Lorem Ipsum humortól, ismétlõdéstõl vagy értelmetlen szavaktól mentes.',
            'A hiedelemmel ellentétben a Lorem Ipsum nem véletlenszerû szöveg. Gyökerei egy Kr. E. 45-ös latin irodalmi klasszikushoz nyúlnak. Richarrd McClintock a virginiai Hampden-Sydney egyetem professzora kikereste az ismeretlenebb latin szavak közül az egyiket (consectetur) egy Lorem Ipsum részletbõl, és a klasszikus irodalmat átkutatva vitathatatlan forrást talált. A Lorem Ipsum az 1.10.32 és 1.10.33-as de Finibus Bonoruem et Malorum részleteibõl származik (A Jó és Rossz határai - Cicero), Kr. E. 45-bõl. A könyv az etika elméletét tanulmányozza, ami nagyon népszerû volt a reneszánsz korban. A Lorem Ipsum elsõ sora, Lorem ipsum dolor sit amet.. a 1.10.32-es bekezdésbõl származik.',
            'A Lorem Ipsum alaprészlete, amit az 1500-as évek óta használtak, az érdeklõdõk kedvéért lent újra megtekinthetõ. Az 1.10.32 és 1.10.33-as bekezdéseket szintén eredeti formájukban reprodukálták a hozzá tartozó angol változattal az 1914-es fordításból H. Rackhamtól.',
        ];

        Page::create([
           'litle'
        ]);
    }
}
