import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:url_launcher/url_launcher.dart';
import 'theme.dart';
import 'header.dart';

class EdukasiPage extends StatelessWidget {
  const EdukasiPage({super.key});

  Future<void> _hubungi(BuildContext context, String nomor) async {
    try {
      final berhasil = await launchUrl(
        Uri(scheme: 'tel', path: nomor),
        mode: LaunchMode.externalApplication,
      );
      if (!berhasil && context.mounted) {
        _tampilkanPesan(context);
      }
    } catch (_) {
      if (context.mounted) _tampilkanPesan(context);
    }
  }

  void _tampilkanPesan(BuildContext context) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          'Panggilan tidak dapat dibuka dari perangkat ini.',
          style: GoogleFonts.plusJakartaSans(color: Colors.white),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return BaseLayout(
      showBackButton: true,
      child: ListView(
        padding: const EdgeInsets.fromLTRB(20, 18, 20, 28),
        children: [
          Text(
            'Informasi & Edukasi',
            style: GoogleFonts.plusJakartaSans(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: AppTheme.textDark,
            ),
          ),
          const SizedBox(height: 6),
          Text(
            'Informasi untuk mengenali kekerasan dan mencari bantuan dengan aman.',
            style: GoogleFonts.plusJakartaSans(
              fontSize: 12,
              height: 1.5,
              color: AppTheme.textGrey,
            ),
          ),
          const SizedBox(height: 20),
          _sectionTitle('Kenali bentuk kekerasan'),
          const SizedBox(height: 10),
          _infoItem(
            Icons.pan_tool_alt_outlined,
            'Fisik',
            'Tindakan yang melukai atau mengancam keselamatan tubuh.',
            const Color(0xFFFFEEF2),
            AppTheme.primaryPink,
          ),
          _infoItem(
            Icons.psychology_alt_outlined,
            'Psikis',
            'Ancaman, penghinaan, intimidasi, atau perilaku yang menimbulkan ketakutan.',
            const Color(0xFFFFF4E5),
            const Color(0xFFC77700),
          ),
          _infoItem(
            Icons.shield_outlined,
            'Seksual dan penelantaran',
            'Perbuatan seksual tanpa persetujuan, eksploitasi, atau tidak terpenuhinya kebutuhan dasar anak.',
            const Color(0xFFEFF6FF),
            const Color(0xFF2563EB),
          ),
          const SizedBox(height: 20),
          _sectionTitle('Jika Anda atau seseorang dalam bahaya'),
          const SizedBox(height: 10),
          _stepItem('1',
              'Utamakan keselamatan dan cari tempat yang lebih aman bila memungkinkan.'),
          _stepItem('2',
              'Hubungi orang tepercaya agar Anda tidak menghadapi situasi ini sendirian.'),
          _stepItem('3',
              'Jika aman dilakukan, simpan informasi kejadian atau bukti. Jangan mengambil risiko untuk mendapatkannya.'),
          _stepItem('4',
              'Hubungi layanan bantuan atau kepolisian untuk mendapatkan pertolongan.'),
          const SizedBox(height: 20),
          _sectionTitle('Mendampingi korban'),
          const SizedBox(height: 10),
          _infoItem(
            Icons.hearing_outlined,
            'Dengarkan tanpa menyalahkan',
            'Berikan ruang untuk bercerita. Hindari pertanyaan yang menghakimi dan hormati pilihan korban.',
            const Color(0xFFEAF7F0),
            const Color(0xFF16845B),
          ),
          _infoItem(
            Icons.lock_outline,
            'Jaga privasi',
            'Jangan menyebarkan identitas, cerita, atau foto korban tanpa izin.',
            const Color(0xFFF2EEFF),
            const Color(0xFF7253B5),
          ),
          const SizedBox(height: 20),
          _sectionTitle('Layanan bantuan'),
          const SizedBox(height: 10),
          _contactItem(
            context,
            icon: Icons.phone_in_talk_outlined,
            title: 'SAPA 129',
            subtitle: 'Layanan KemenPPPA untuk perempuan dan anak',
            color: AppTheme.primaryPink,
            onTap: () => _hubungi(context, '129'),
          ),
          const SizedBox(height: 8),
          _contactItem(
            context,
            icon: Icons.local_police_outlined,
            title: 'Polisi 110',
            subtitle: 'Hubungi saat membutuhkan bantuan kepolisian',
            color: const Color(0xFF2563EB),
            onTap: () => _hubungi(context, '110'),
          ),
          const SizedBox(height: 14),
          Text(
            'Jika panggilan tidak dapat dilakukan dari aplikasi, gunakan aplikasi Telepon pada perangkat Anda.',
            style: GoogleFonts.plusJakartaSans(
              fontSize: 11,
              height: 1.4,
              color: AppTheme.textGrey,
            ),
          ),
        ],
      ),
    );
  }

  Widget _sectionTitle(String title) => Text(
        title,
        style: GoogleFonts.plusJakartaSans(
          fontSize: 14,
          fontWeight: FontWeight.bold,
          color: AppTheme.textDark,
        ),
      );

  Widget _infoItem(
    IconData icon,
    String title,
    String description,
    Color iconBackground,
    Color iconColor,
  ) =>
      Container(
        margin: const EdgeInsets.only(bottom: 8),
        padding: const EdgeInsets.all(14),
        decoration: BoxDecoration(
          color: Colors.white,
          border: Border.all(color: const Color(0xFFF0F0F2)),
          borderRadius: BorderRadius.circular(12),
        ),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: iconBackground,
                borderRadius: BorderRadius.circular(9),
              ),
              child: Icon(icon, size: 19, color: iconColor),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: GoogleFonts.plusJakartaSans(
                      fontSize: 12,
                      fontWeight: FontWeight.bold,
                      color: AppTheme.textDark,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    description,
                    style: GoogleFonts.plusJakartaSans(
                      fontSize: 11,
                      height: 1.45,
                      color: AppTheme.textGrey,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      );

  Widget _stepItem(String number, String description) => Padding(
        padding: const EdgeInsets.only(bottom: 10),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              width: 24,
              height: 24,
              alignment: Alignment.center,
              decoration: const BoxDecoration(
                color: Color(0xFFFFEEF2),
                shape: BoxShape.circle,
              ),
              child: Text(
                number,
                style: GoogleFonts.plusJakartaSans(
                  fontSize: 11,
                  fontWeight: FontWeight.bold,
                  color: AppTheme.primaryPink,
                ),
              ),
            ),
            const SizedBox(width: 10),
            Expanded(
              child: Padding(
                padding: const EdgeInsets.only(top: 3),
                child: Text(
                  description,
                  style: GoogleFonts.plusJakartaSans(
                    fontSize: 12,
                    height: 1.45,
                    color: AppTheme.textDark,
                  ),
                ),
              ),
            ),
          ],
        ),
      );

  Widget _contactItem(
    BuildContext context, {
    required IconData icon,
    required String title,
    required String subtitle,
    required Color color,
    required VoidCallback onTap,
  }) =>
      Material(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        child: InkWell(
          onTap: onTap,
          borderRadius: BorderRadius.circular(12),
          child: Container(
            padding: const EdgeInsets.all(14),
            decoration: BoxDecoration(
              border: Border.all(color: const Color(0xFFF0F0F2)),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Row(
              children: [
                Icon(icon, color: color, size: 22),
                const SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        title,
                        style: GoogleFonts.plusJakartaSans(
                          fontSize: 12,
                          fontWeight: FontWeight.bold,
                          color: AppTheme.textDark,
                        ),
                      ),
                      const SizedBox(height: 3),
                      Text(
                        subtitle,
                        style: GoogleFonts.plusJakartaSans(
                          fontSize: 11,
                          color: AppTheme.textGrey,
                        ),
                      ),
                    ],
                  ),
                ),
                Icon(Icons.call_outlined, color: color, size: 18),
              ],
            ),
          ),
        ),
      );
}
