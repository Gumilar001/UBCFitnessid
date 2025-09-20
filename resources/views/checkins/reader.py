from smartcard.CardMonitoring import CardMonitor, CardObserver
from smartcard.System import readers
import os

# Command untuk baca UID
GET_UID = [0xFF, 0xCA, 0x00, 0x00, 0x00]

UID_FILE = "C:/Users/ANGEL/Documents/PROJECT/GYM/UBCFitnessid/public/uid.txt"

class RFIDObserver(CardObserver):
    def update(self, observable, actions):
        (added_cards, removed_cards) = actions

        for card in added_cards:
            print(f"[+] Kartu terdeteksi di {card.reader}")
            try:
                reader_obj = [r for r in readers() if str(r) == card.reader][0]

                connection = reader_obj.createConnection()
                connection.connect()

                data, sw1, sw2 = connection.transmit(GET_UID)
                if sw1 == 0x90 and sw2 == 0x00:
                    uid = ''.join(format(x, '02X') for x in data)
                    print(f"UID: {uid}")

                    # simpan ke file supaya PHP bisa baca
                    with open(UID_FILE, "w") as f:
                        f.write(uid)

                else:
                    print(f"Gagal baca UID: SW1={sw1:02X}, SW2={sw2:02X}")

            except Exception as e:
                print("Error:", e)

        for card in removed_cards:
            print(f"[-] Kartu dilepas dari {card.reader}")
            # hapus isi file saat kartu dilepas
            with open(UID_FILE, "w") as f:
                f.write("")

if __name__ == "__main__":
    print("Daemon berjalan... Tap kartu RFID (Ctrl+C untuk berhenti)")
    card_monitor = CardMonitor()
    card_observer = RFIDObserver()
    card_monitor.addObserver(card_observer)

    try:
        import time
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        print("Berhenti.")
        card_monitor.deleteObserver(card_observer)
