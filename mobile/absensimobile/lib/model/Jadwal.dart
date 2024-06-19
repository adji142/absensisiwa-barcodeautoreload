import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:absensimobile/shared/Session.dart';

class Jadwal {
  Session? sess;
  Map? Parameter;

  Jadwal({this.sess, this.Parameter});

  Future<Map> getJadwal() async {
    var url = Uri.parse("${sess!.server}getjadwal");
    final response = await http.post(url, body: Parameter);
    print(Parameter);
    return json.decode(response.body);
  }

  String convertDayName(String enDayName) {
    var idDayName = "";
    switch (enDayName) {
    		case 'Monday':
    			idDayName = "Senin";
    			break;
    		case 'Tuesday':
    			idDayName = "Selasa";
    			break;
    		case 'Wednesday':
    			idDayName = "Rabu";
    			break;
    		case 'Thursday':
    			idDayName = "Kamis";
    			break;
    		case 'Friday':
    			idDayName = "Jumat";
    			break;
    		case 'Saturday':
    			idDayName = "Sabtu";
    			break;
    		case 'Sunday':
    			idDayName = "Minggu";
    			break;
    		
    		default:
    			idDayName = "Minggu";
    			break;
    	}
    return idDayName;
  }
}
