#include "stdafx.h"

#include "stdio.h"
#include "conio.h"
#include <string>
#include <vector>
#include <windows.h>

using namespace  std;

string revertCharacters(string s) {
	int size = s.size();

	if (size<=1) { // ignore empty string or string with one chracter
		return s;
	}

	int pos1=0,pos2=0,p1=0,p2=0;
	while(pos2 != size) {

		bool isFoundOrEnd = false;
		do {
			pos2++;
			if (s[pos2]==' ' || s[pos2]=='.'||  s[pos2]==',' || s[pos2]=='!' || s[pos2]=='?'|| pos2 == size) {
				pos2--;

				if (s[pos1]==s[pos2] ) {
					pos2++;
					pos1 = pos2;
					pos1++;
				} else {
					isFoundOrEnd = true;
				}
			}
		}while (!isFoundOrEnd);

		// Reversing chunk
		{
			p1 = pos1; p2 = pos2;

			while(p1<p2){
				// swap characters within chunk
				char tmp = s[p1];
				s[p1] = s[p2];
				s[p2] = tmp;
				p1++;
				p2--;
			} 
		}
		// shift frame
		{
			pos2++;
			pos1 = pos2;
			pos1++;
		} 
	};
	return s;
}

int main(){
	SetConsoleOutputCP(1251);
	SetConsoleCP(1251);


	vector<string> texts;
	texts.push_back("Привет! Давно не виделись."); // TEST #1 original test text
	texts.push_back("Привет!...Давно не виделись, КОЗЁЛ!!!!! Что!!! Я???   Да!Ты, Лысый!!!Я тебя завалю! "); // TEST #2 Check for many repating punctuation characters (?!., )
	texts.push_back("Улыбок тебе, дед Макар!");	 // TEST #3

	for(auto& txt: texts) {
		string res = revertCharacters(txt);
		printf("%s \n",res.c_str());
	}

	_getch();

    return 0;
}

