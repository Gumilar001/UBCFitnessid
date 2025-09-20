from smartcard.System import readers

# Ambil daftar reader
r = readers()
if len(r) == 0:
    print("Tidak ada reader terdeteksi")
    exit()

reader = r[0]
print("Menggunakan reader:", reader)

connection = reader.createConnection()
connection.connect()

# APDU command untuk baca UID (standard untuk ACR122U)
GET_UID = [0xFF, 0xCA, 0x00, 0x00, 0x00]
data, sw1, sw2 = connection.transmit(GET_UID)

if sw1 == 0x90 and sw2 == 0x00:
    uid = ''.join(format(x, '02X') for x in data)
    print("UID:", uid)
else:
    print("Gagal baca UID. SW1=%02X SW2=%02X" % (sw1, sw2))
