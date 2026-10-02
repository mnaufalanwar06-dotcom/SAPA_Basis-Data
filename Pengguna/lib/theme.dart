import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

class AppTheme {
  // Emulator Android memakai 10.0.2.2, sedangkan HP fisik memakai IP laptop.
  static String get apiUrl {
    if (kIsWeb) {
      final host = Uri.base.host.isEmpty ? 'localhost' : Uri.base.host;
      return 'http://$host:8000/api';
    }
    return 'http://192.168.1.7:8000/api';
  }

  static const Color primaryPink = Color(0xFFE0245E);
  static const Color headerPink = Color(0xFFFF4B72);
  static const Color bgLight = Color(0xFFFBFBFD);
  static const Color cardBg = Colors.white;
  static const Color textDark = Color(0xFF2D2D2D);
  static const Color textGrey = Color(0xFF8A8A8E);
  static const Color borderPink = Color(0xFFFFD2DC);
  static const Color successGreen = Color(0xFF10B981);

  static const Color badgeYellowBg = Color(0xFFFFF8E6);
  static const Color badgeYellowText = Color(0xFFF5A623);
  static const Color badgeBlueBg = Color(0xFFEFF6FF);
  static const Color badgeBlueText = Color(0xFF2563EB);
  static const Color badgeGreenBg = Color(0xFFECFDF5);
  static const Color badgeGreenText = Color(0xFF059669);
}

class UserSession {
  static Map<String, dynamic>? currentUser;

  static String get name => currentUser?['name'] ?? currentUser?['nama'] ?? 'Pengguna';
  static String get email => currentUser?['email'] ?? 'pengguna@gmail.com';
  static int? get id => currentUser?['id'];
}