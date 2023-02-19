for file in tz*.mp3
do
    ffmpeg -y -i "$file" -af "silenceremove=start_periods=1:stop_periods=-1:start_threshold=-70dB:stop_threshold=-70dB:start_silence=2:stop_silence=2" "tr_$file"
done
