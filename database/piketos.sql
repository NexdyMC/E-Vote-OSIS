




create table tb_siswa (
  token varchar(10) primary key,
  nama varchar(20),
  kelas varchar(10),
  status boolean default false,
  voted int default 0
)
create table tb_kardidat 